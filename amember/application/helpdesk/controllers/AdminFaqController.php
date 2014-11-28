<?php

class Am_Form_Admin_HelpdeskFaq extends Am_Form_Admin
{

    function init()
    {
        $catoptions = array_filter(Am_Di::getInstance()->helpdeskFaqTable->getCategories());
        $catoptions = array_merge(array('' => ___('-- Without A Category --')), $catoptions);

        $this->addSelect('category', array(),
                array('intrinsic_validation' => false, 'options' => $catoptions))
            ->setLabel('Category');

        $label_add_category = ___('add category');
        $label_title_error = ___('Enter title for your new category');
        $this->addScript()
            ->setScript(<<<CUT
jQuery(function($){
    $("select[name='category']").prop("id", "category").after($("<span> <a href='javascript:;' id='add-category' class='local'>$label_add_category</a></span>"));

    $("select[name='category']").change(function(){
        $(this).toggle($(this).find('option').length > 1);
    }).change();


    $(document).on('click',"a#add-category", function(){
        var ret = prompt("$label_title_error", "");
        if (!ret) return;
        var \$sel = $("select#category").append(
            $("<option></option>").val(ret).html(ret));
        \$sel.val(ret).change();
    });
})
CUT
        );

        $this->addText('title', array('class' => 'el-wide'))
            ->setLabel(___('Title'));
        $this->addHtmlEditor('content')
            ->setLabel(___('Content'));
    }

}

class Am_Grid_Filter_HelpdeskFaq extends Am_Grid_Filter_Abstract
{

    public function getTitle()
    {
        return ___('Filter By Title or Category');
    }

    protected function applyFilter()
    {
        if ($this->isFiltered()) {
            $q = $this->grid->getDataSource();
            /* @var $q Am_Query */
            $q->addWhere('title LIKE ? OR category LIKE ?',
                '%' . $this->vars['filter'] . '%',
                '%' . $this->vars['filter'] . '%');
        }
    }

    public function renderInputs()
    {
        return $this->renderInputText();
    }

}

class Am_Grid_Action_EditFaqCategory extends Am_Grid_Action_Abstract
{

    protected $type = self::NORECORD;
    protected $url;
    protected $attributes = array(
        'target' => '_top'
    );

    public function getUrl($record = null, $id = null)
    {
        return REL_ROOT_URL . '/helpdesk/admin-faq/category';
    }

    public function run()
    {
        //nop
    }

}

class Am_Grid_Action_Back extends Am_Grid_Action_Abstract
{

    protected $type = self::NORECORD;
    protected $url;
    protected $attributes = array(
        'target' => '_top'
    );

    public function getUrl($record = null, $id = null)
    {
        return REL_ROOT_URL . '/helpdesk/admin-faq/';
    }

    public function run()
    {
        //nop
    }

}

class Am_Grid_DataSource_FaqCategory extends Am_Grid_DataSource_Array
{

    public function updateRecord($record, $valuesFromForm)
    {
        Am_Di::getInstance()->db->query('UPDATE ?_helpdesk_faq SET category=? WHERE category=?',
            $valuesFromForm['name'],
            $record->name);
    }

}

class Helpdesk_AdminFaqController extends Am_Controller_Grid
{

    public function checkAdminPermissions(Admin $admin)
    {
        return $admin->hasPermission(Bootstrap_Helpdesk::ADMIN_PERM_FAQ);
    }

    public function createGrid()
    {
        $ds = new Am_Query($this->getDi()->helpdeskFaqTable);
        $ds->setOrder('sort_order');
        $grid = new Am_Grid_Editable('_helpdesk_faq', ___('FAQ'), $ds, $this->_request, $this->view);

        $grid->addField(new Am_Grid_Field('title', ___('Title'), true, '', null, '50%'));
        $grid->addField(new Am_Grid_Field('category', ___('Category')));
        $grid->addField('_link', ___('Link'), false)->setRenderFunction(array($this, 'renderLink'));
        $grid->setForm('Am_Form_Admin_HelpdeskFaq');
        $grid->setFilter(new Am_Grid_Filter_HelpdeskFaq());
        $grid->addCallback(Am_Grid_Editable::CB_VALUES_FROM_FORM, array($this, 'valuesFromForm'));
        $grid->setPermissionId(Bootstrap_Helpdesk::ADMIN_PERM_FAQ);
        $grid->actionAdd(new Am_Grid_Action_Sort_HelpdeskFaq());

        if ($this->getDi()->helpdeskFaqTable->getCategories()) {
            $grid->actionAdd(new Am_Grid_Action_EditFaqCategory('faq-edit-category', ___('Edit Categories')));
        }

        return $grid;
    }

    public function categoryAction()
    {
        $ret = array();
        foreach ($this->getDi()->helpdeskFaqTable->getCategories() as $category) {
            $cat = new stdClass();
            $cat->name = $category;
            $ret[] = $cat;
        }

        $ds = new Am_Grid_DataSource_FaqCategory($ret);
        $grid = new Am_Grid_Editable('_helpdesk_faq_category', ___('Categories'), $ds, $this->_request, $this->view);
        $grid->setPermissionId(Bootstrap_Helpdesk::ADMIN_PERM_FAQ);
        $grid->addField(new Am_Grid_Field('name', ___('Title')));
        $grid->actionsClear();
        $grid->actionAdd(new Am_Grid_Action_Back('faq-edit-category-back', ___('Back to FAQ List')));
        $grid->actionAdd(new Am_Grid_Action_LiveEdit('name'));
        $grid->runWithLayout('admin/layout.phtml');
    }

    public function valuesFromForm(& $ret, HelpdeskFaq $record)
    {
        if (!isset($ret['category']) || !$ret['category'])
            $ret['category'] = null;
    }

    public function renderLink(Am_Record $record)
    {
        $url = sprintf('%s/helpdesk/faq/i/%s', ROOT_URL, urlencode($record->title));
        return $this->renderTd(sprintf('<a class="link" href="%s" target="_blank">%s</a>',
                Am_Controller::escape($url), ___('link')), false);
    }

}

class Am_Grid_Action_Sort_HelpdeskFaq extends Am_Grid_Action_Sort_Abstract
{

    protected function setSortBetween($item, $after, $before)
    {
        $this->_simpleSort(Am_Di::getInstance()->helpdeskFaqTable, $item, $after, $before);
    }

}