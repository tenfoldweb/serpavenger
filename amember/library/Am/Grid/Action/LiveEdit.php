<?php

/**
 * Provide live-edit functionality for a field
 */
class Am_Grid_Action_LiveEdit extends Am_Grid_Action_Abstract
{
    protected $privilege = 'edit';
    protected $type = self::HIDDEN;
    protected $fieldName;
    protected $placeholder = null;
    protected $initCallback;
    /** @var Am_Grid_Decorator_LiveEdit */
    protected $decorator;
    
    public function __construct($fieldName, $placeholder=null)
    {
        $this->placeholder = is_null($placeholder) ? ___('Click to Edit') : $placeholder;
        $this->fieldName = $fieldName;
        $this->decorator = new Am_Grid_Field_Decorator_LiveEdit($this);
        parent::__construct('live-edit-' . $fieldName, ___("Live Edit %s", ___(ucfirst($fieldName)) ));
    }
    public function setGrid(Am_Grid_Editable $grid)
    {
        parent::setGrid($grid);
        if ($this->hasPermissions()) {
            $grid->getField($this->fieldName)->addDecorator($this->decorator);
            $grid->addCallback(Am_Grid_ReadOnly::CB_RENDER_STATIC, array($this, 'renderStatic'));
        }
    }
    
    function renderStatic(& $out) {
        $out .= <<<CUT
<script type="text/javascript">
// simple function to extract params from url
$(document).on('click',"td:has(span.live-edit)", function(event)
{
    // protection against double run (if 2 live edit grids on page)
    if (event.liveEditHandled) return;
    event.liveEditHandled = true;
    //

    if ($(this).data('mode') == 'edit') return;

    (function() {
        var txt = $(this);
        txt.toggleClass('live-edit-placeholder', txt.text() == txt.attr("placeholder"));
        var edit = txt.closest("td").find("input.live-edit");
        if (!edit.length) {
            edit = $(txt.attr("livetemplate"));
            if (txt.text() != txt.attr('placeholder')) {
                edit.val(txt.text());
            }
            txt.data("prev-val", edit.val());
            edit.attr("name", txt.attr("id"));
            edit.attr({'class' : 'el-wide'})
            txt.after(edit);
            if (txt.data('init-callback')) {
                eval(txt.data('init-callback')).call(edit);
            }
            edit.focus();
        }
        txt.hide();
        txt.closest('td').data('mode', 'edit');
        txt.closest('td').find('.editable').hide();
        edit.show();

        function stopEdit(txt, edit, val)
        {
            var text = val ? val : txt.attr("placeholder");
            txt.text(text);
            txt.toggleClass('live-edit-placeholder', text == txt.attr("placeholder"))
            edit.remove();
            txt.show();
            txt.closest('td').data('mode', 'display');
            txt.closest('td').find('.editable').show();
        }

        // bind outerclick event
        $("body").bind("click.inplace-edit", function(event){
            if (event.target != edit[0])
            {
                $("body").unbind("click.inplace-edit");
                var vars = $.parseJSON(txt.attr("livedata"));
                if (!vars) vars = {};
                vars[edit.attr("name")] = edit.val();
                if (edit.val() != txt.data('prev-val')) {
                    $.post(txt.attr("liveurl"), vars, function(res){
                        if (res.ok && res.ok) {
                            stopEdit(txt, edit, edit.val());
                        } else {
                            flashError(res.message ? res.message : 'Internal Error');
                            stopEdit(txt, edit, txt.data('prev-val'));
                        }
                    });
                } else {
                    stopEdit(txt, edit, edit.val());
                }
            }
        });
    }).apply($(this).find("span.live-edit").get(0));
});       
</script>    
CUT;
    }
    
    function getPlaceholder() {
        return $this->placeholder;
    }
    
    /** @return Am_Grid_Field_Decorator_LiveEdit */
    function getDecorator()
    {
        return $this->decorator;
    }
    public function getIdForRecord($obj)
    {
        return $this->grid->getDataSource()->getIdForRecord($obj);
    }
    public function run()
    {
        try {
            $prefix = $this->fieldName . '-';
            $ds = $this->grid->getDataSource();
            foreach ($this->grid->getRequest()->getPost() as $k => $v)
            {
                if (strpos($k, $prefix)===false) continue;
                $id = filterId(substr($k, strlen($prefix)));
                $record = $ds->getRecord($id);
                if (!$record) throw new Am_Exception_InputError("Record [$id] not found");
                $ds->updateRecord($record, array($this->fieldName => $v));
                $this->log('LiveEdit [' . $this->fieldName . ']');
            }
            Am_Controller::ajaxResponse(array('ok'=>true, 'message'=>___("Field Updated")));
        } catch (Exception $e) {
            Am_Controller::ajaxResponse(array('ok'=>false, 'error' => true, 'message'=>$e->getMessage()));
        }
    }

    public function setInitCallback($callback)
    {
        $this->initCallback = $callback;
        return $this;
    }
    public function getInitCallback()
    {
        return $this->initCallback;
    }
}