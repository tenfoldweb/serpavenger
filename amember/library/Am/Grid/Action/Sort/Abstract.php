<?php

abstract class Am_Grid_Action_Sort_Abstract extends Am_Grid_Action_Abstract
{
    protected $type = self::HIDDEN;
    protected $privilege = 'edit';
    /** @var Am_Grid_Decorator_LiveEdit */
    protected $decorator;
    protected static $jsIsAlreadyAdded = false;

    public function setGrid(Am_Grid_Editable $grid)
    {
        parent::setGrid($grid);
        if ($this->hasPermissions()) {
            $grid->addCallback(Am_Grid_ReadOnly::CB_TR_ATTRIBS, array($this, 'getTrAttribs'));
            $grid->addCallback(Am_Grid_Editable::CB_RENDER_CONTENT, array($this, 'renderContent'));
            $grid->prependField(new Am_Grid_Field_Sort('_sort'));
        }
    }

    final public function getTrAttribs(array & $attribs, $obj)
    {
        $grid_id = $this->grid->getId();
        $params = array(
            $grid_id . '_' . Am_Grid_ReadOnly::ACTION_KEY => $this->getId(),
            $grid_id . '_' . Am_Grid_ReadOnly::ID_KEY => $this->grid->getDataSource()->getIdForRecord($obj),
        );
        $attribs['data-params'] = json_encode($params);
        $attribs['data-sort-record'] = json_encode($this->getRecordParams($obj));
    }

    public function renderContent(& $out, Am_Grid_Editable $grid)
    {
        $url = json_encode($grid->makeUrl());
        $grid_id = $this->grid->getId();
        $msg = ___("Drag&Drop rows to change display order. You may want to temporary change setting '%sRecords per Page (for grids)%s' to some big value so all records were on one page and you can arrange all items.",
            '<a class="link" href="' . REL_ROOT_URL . '/admin-setup" target="_top">','</a>');
        $out .= <<<CUT
<div class="am-grid-drag-sort-message"><i>$msg</i></div>
<script type="text/javascript">
jQuery(function($){
    $(".grid-wrap").ngrid("onLoad", function(){
        if ($(this).find("th .sorted-asc, th .sorted-desc").length)
        {
            $('.am-grid-drag-sort-message').remove();
            $(this).sortable( "destroy" );
            return;
        }

        //prepend mousedown event to td.record-sort
        //the handlers of ancestors are called before
        //the event reaches the element
        var grid = $(this);
        $(this).mousedown(function(event) {
            if ($(event.target).hasClass('record-sort')) {
                var offset = 0;
                grid.find('.expandable-data-row').each(function(){
                    offset += $(this).offset().top > event.pageY ?
                                0 :
                                $(this).outerHeight();
                })
                grid.find('.expanded').click();
                event.pageY -= offset;
            }
        });

        $(this).sortable({
            items: "tbody > tr.grid-row",
            handle: "td.record-sort",
            update: function(event, ui) {
                var item = $(ui.item);
                var url = $url;
                var params = item.data('params');
                $.each(item.closest('table').find('tr.grid-row'), function(index, el) {
                    $(el).removeClass('odd');
                    ((index+1) % 2) || $(el).addClass('odd');
                })

                params.{$grid_id}_move_item = {};
                $.each(item.data('sort-record'), function(index, value) {
                    params.{$grid_id}_move_item[index] = value;
                })

                if(item.prev().data('sort-record')) {
                    params.{$grid_id}_move_after = {};
                    $.each(item.prev().data('sort-record'), function(index, value) {
                        params.{$grid_id}_move_after[index] = value;
                    })
                }

                if (item.next().data('sort-record')) {
                    params.{$grid_id}_move_before = {};
                    $.each(item.next().data('sort-record'), function(index, value) {
                        params.{$grid_id}_move_before[index] = value;
                    })
                }

                $.post(url, params, function(response){});
            },
        });
    });
});
</script>
CUT;
    }

    public function run()
    {
        $request = $this->grid->getRequest();
        $id = $request->getFiltered('id');
        $move_before = $request->getParam('move_before', null);
        $move_after = $request->getParam('move_after', null);
        $move_item = $request->getParam('move_item');

        $resp = array(
            'ok' => true,
        );
        if ($this->callback)
            $resp['callback'] = $this->callback;
        try {
            $this->setSortBetween($move_item, $move_after, $move_before);
        } catch (Exception $e) {
            throw $e;
            $resp = array('ok' => false, );
        }
        Am_Controller::ajaxResponse($resp);
        exit();
    }

    protected function getRecordParams($obj)
    {
        return array(
            'id' => $this->grid->getDataSource()->getIdForRecord($obj),
        );
    }

    protected function _simpleSort(Am_Table $table, $item, $after, $before) {
        $after = $after ? $after['id'] : null;
        $before = $before ? $before['id'] : null;
        $id = $item['id'];

        $table_name = $table->getName();
        $pk = $table->getKeyField();

        $db = Am_Di::getInstance()->db;
        $item = $table->load($id);
        if ($before) {
            $beforeItem = $table->load($before);

            $sign = $beforeItem->sort_order > $item->sort_order ?
                '-':
                '+';

            $newSortOrder = $beforeItem->sort_order > $item->sort_order ?
                $beforeItem->sort_order-1:
                $beforeItem->sort_order;

            $db->query("UPDATE $table_name
                SET sort_order=sort_order{$sign}1 WHERE
                sort_order BETWEEN ? AND ? AND $pk<>?",
                min($newSortOrder, $item->sort_order),
                max($newSortOrder, $item->sort_order),
                $id);

            $db->query("UPDATE $table_name SET sort_order=? WHERE $pk=?", $newSortOrder, $id);

        } elseif ($after) {
            $afterItem = $table->load($after);

            $sign = $afterItem->sort_order > $item->sort_order ?
                '-':
                '+';

             $newSortOrder = $afterItem->sort_order > $item->sort_order ?
                $afterItem->sort_order:
                $afterItem->sort_order+1;

            $db->query("UPDATE $table_name
                SET sort_order=sort_order{$sign}1 WHERE
                sort_order BETWEEN ? AND ? AND $pk<>?",
                min($newSortOrder, $item->sort_order),
                max($newSortOrder, $item->sort_order),
                $id);

            $db->query("UPDATE $table_name SET sort_order=? WHERE $pk=?", $newSortOrder, $id);
        }
    }

    abstract protected function setSortBetween($item, $after, $before);
}

class Am_Grid_Field_Sort extends Am_Grid_Field
{
    public function __construct($field='_', $title=null, $sortable = true, $align = null, $renderFunc = null, $width = null)
    {
        parent::__construct($field, '', false);
        $this->addDecorator(new Am_Grid_Field_Decorator_Sort());
    }
    public function render($obj, $grid)
    {
        /* @var $grid Am_Grid_ReadOnly */
        return $grid->getRequest()->getParam('sort') ?
            '' :
            '<td class="record-sort" nowrap width="1%">&nbsp;</td>';
    }
}

class Am_Grid_Field_Decorator_Sort extends Am_Grid_Field_Decorator_Abstract {
    function renderTitle(& $out, $controller)
    {
        /* @var $controller Am_Grid_ReadOnly */
        $out = $controller->getRequest()->getParam('sort') ?
            '' :
            preg_replace('#^(<th)#i', '$1 class="record-sort" ', $out);
    }
}