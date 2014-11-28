<?php

class Am_Grid_Action_Group_ContentAssignCategory extends Am_Grid_Action_Group_Abstract
{

    protected $needConfirmation = true;
    protected $remove = false;

    public function __construct($removeGroup = false)
    {
        $this->remove = (bool) $removeGroup;
        parent::__construct(
                !$removeGroup ? "content-assign-category" : "content-remove-category",
                !$removeGroup ? ___("Assign Category") : ___("Remove Category")
        );
    }

    public function renderConfirmationForm($btn = "Yes, assign", $page = null, $addHtml = null)
    {
        $select = sprintf('<select name="%s__group_id">
            %s
            </select><br /><br />' . PHP_EOL,
                $this->grid->getId(),
                Am_Controller::renderOptions(Am_Di::getInstance()->resourceCategoryTable->getOptions())
        );
        return parent::renderConfirmationForm($this->remove ? ___("Yes, remove category") : ___("Yes, assign category"), null, $select);
    }

    /**
     * @param int $id
     * @param User $record
     */
    public function handleRecord($id, $record)
    {
        $group_id = $this->grid->getRequest()->getInt('_group_id');
        if (!$group_id)
            throw new Am_Exception_InternalError("_group_id empty");
        $groups = $record->getCategories();
        if ($this->remove) {
            if (!in_array($group_id, $groups))
                return;
            foreach ($groups as $k => $id)
                if ($id == $group_id)
                    unset($groups[$k]);
        } else {
            if (in_array($group_id, $groups))
                return;
            $groups[] = $group_id;
        }
        $record->setCategories($groups);
    }

}

class Am_Grid_Filter_Content_Folder extends Am_Grid_Filter_Abstract
{

    protected $varList = array('filter_q', 'filter_t');

    protected function applyFilter()
    {
        $query = $this->grid->getDataSource()->getDataSourceQuery();
        $type = $this->getParam('filter_t');

        if (!in_array($type, array('url', 'path', 'title'))) {
            $type = 'title';
        }
        if ($filter = $this->getParam('filter_q')) {
            $condition = new Am_Query_Condition_Field($type, 'LIKE', '%' . $filter . '%');
            $query->add($condition);
        }
    }

    function renderInputs()
    {
        $filter = '';
        $filter .= $this->renderInputText('filter_q');
        $filter .= ' ';
        $filter .= $this->renderInputSelect('filter_t', array(
                'title' => ___('Title'),
                'url' => ___('URL'),
                'path' => ___('Path')
            ));
        return $filter;
    }

    function getTitle()
    {
        return ___('Filter by String');
    }

}

class Am_Grid_Action_EmailPreview extends Am_Grid_Action_Abstract
{

    protected $type = Am_Grid_Action_Abstract::SINGLE;

    public function run()
    {
        if ($this->grid->getRequest()->getParam('preview')) {
            $session = new Zend_Session_Namespace('email_preview');
            echo $session->output;
            exit;
        }
        $f = $this->createForm();
        $f->setDataSources(array($this->grid->getCompleteRequest()));
        echo $this->renderTitle();
        if ($f->isSubmitted() && $f->validate() && $this->process($f))
            return;
        echo $f;
    }

    function process(Am_Form $f)
    {
        $vars = $f->getValue();
        $user = Am_Di::getInstance()->userTable->findFirstByLogin($vars['user']);
        if (!$user) {
            list($el) = $f->getElementsByName('user');
            $el->setError(___('User %s not found', $vars['user']));
            return false;
        }

        $product = Am_Di::getInstance()->productTable->load($vars['product_id']);
        $template = $this->grid->getRecord();
        $mail = Am_Mail_Template::createFromEmailTemplate($template);

        switch ($template->name) {
            case 'autoresponder':
                $mail->setLast_product_title($product->title);
                break;
            case 'expire':
                $mail->setProduct_title($product->title);
                break;
            default:
                throw new Am_Exception_InternalError('Unknown email template name [%s]', $template->name);
        }

        $mail->setUser($user);
        $mail->send($user, new Am_Mail_Transport_Null());
        if ($template->format == 'text') {
            printf('<div style="margin-bottom:0.5em;">%s: <strong>%s</strong></div><div style="border:1px solid #2E2E2E; width:%s"><pre>%s</pre></div>',
                ___('Subject'), Am_Controller::escape($this->getSubject($mail)),
                '100%', Am_Controller::escape($mail->getMail()->getBodyText()->getRawContent()));
        } else {
            $session = new Zend_Session_Namespace('email_preview');
            $session->output = $mail->getMail()->getBodyHtml()->getRawContent();
            printf('<div style="margin-bottom:0.5em;">%s: <strong>%s</strong></div><iframe  style="border:1px solid #2E2E2E; width:%s; height:300px" src="%s/default/admin-content/p/emails/index?_emails_a=preview&_emails_id=67&_emails_preview=1"></iframe>',
                ___('Subject'), Am_Controller::escape($this->getSubject($mail)),
                '100%', REL_ROOT_URL);
        }
        return true;
    }

    protected function getSubject($mail)
    {
        $subject = $mail->getMail()->getSubject();
        if (strpos($subject, '=?') === 0)
            $subject = mb_decode_mimeheader($subject);
        return $subject;
    }

    protected function createForm()
    {
        $f = new Am_Form_Admin;
        $f->addText('user')->setLabel(___('Enter username of existing user'))
            ->addRule('required');
        $f->addSelect('product_id')
            ->setLabel(___('Product'))
            ->loadOptions(Am_Di::getInstance()->productTable->getOptions());
        $f->addScript()->setScript(<<<CUT
$(function(){
    $("#user-0" ).autocomplete({
        minLength: 2,
        source: window.rootUrl + "/admin-users/autocomplete"
    });
});
CUT
        );
        $f->addSaveButton(___('Preview'));
        foreach ($this->grid->getVariablesList() as $k) {
            $kk = $this->grid->getId() . '_' . $k;
            if ($v = @$_REQUEST[$kk])
                $f->addHidden($kk)->setValue($v);
        }
        return $f;
    }

}

class Am_Grid_Action_PagePreview extends Am_Grid_Action_Abstract
{

    protected $type = Am_Grid_Action_Abstract::SINGLE;

    public function run()
    {
        $f = $this->createForm();
        $f->setDataSources(array($this->grid->getCompleteRequest()));
        if ($f->isSubmitted() && $f->validate() && $this->process($f))
            return;
        echo $this->renderTitle();
        echo $f;
    }

    function process(Am_Form $f)
    {
        $vars = $f->getValue();
        $user = Am_Di::getInstance()->userTable->findFirstByLogin($vars['user']);
        if (!$user) {
            list($el) = $f->getElementsByName('user');
            $el->setError(___('User %s not found', $vars['user']));
            return false;
        }

        $page = $this->grid->getRecord();

        echo $page->render(Am_Di::getInstance()->view, $user);
        exit;
    }

    protected function createForm()
    {
        $f = new Am_Form_Admin;
        $f->addText('user')->setLabel(___('Enter username of existing user'))
            ->addRule('required');
        $f->addScript()->setScript(<<<CUT
$(function(){
    $("#user-0" ).autocomplete({
        minLength: 2,
        source: window.rootUrl + "/admin-users/autocomplete"
    });
});
CUT
        );
        $f->addSaveButton(___('Preview'));
        foreach ($this->grid->getVariablesList() as $k) {
            $kk = $this->grid->getId() . '_' . $k;
            if ($v = @$_REQUEST[$kk])
                $f->addHidden($kk)->setValue($v);
        }
        return $f;
    }

}

class Am_Form_Element_PlayerConfig extends HTML_QuickForm2_Element
{

    protected $value;
    /* @var HTML_QuickForm2_Element_InputHidden */
    protected $elHidden;
    /* @var HTML_QuickForm2_Element_Select */
    protected $elSelect;

    public function __construct($name = null, $attributes = null, array $data = array())
    {

        $this->elHidden = new HTML_QuickForm2_Element_InputHidden($name);
        $this->elHidden->setContainer($this->getContainer());

        $this->elSelect = new HTML_QuickForm2_Element_Select('__' . $name);

        $this->elSelect->loadOptions(array(
            '--global--' => ___('Use Global Settings'),
            '--custom--' => ___('Use Custom Settings')
            )
        );

        $this->addPresets($this->elSelect);
        parent::__construct($name, $attributes, $data);
    }

    public function getType()
    {
        return 'player-config';
    }

    public function getRawValue()
    {
        return $this->elHidden->getRawValue();
    }

    public function updateValue()
    {
        $this->elHidden->setContainer($this->getContainer());
        $this->elHidden->updateValue();
        $this->setValue($this->elHidden->getRawValue());
    }

    public function setValue($value)
    {
        if (!$value) {
            $this->elSelect->setValue('--global--');
        } elseif (@unserialize($value)) {
            $this->elSelect->setValue('--custom--');
        } else {
            $this->elSelect->setValue($value);
        }
        $this->elHidden->setValue($value);
    }

    public function __toString()
    {
        return sprintf('<div class="player-config">%s%s <div class="player-config-edit"><a href="javascript:;" class="local">%s</div><div class="player-config-delete"><a href="javascript:;" class="local">%s</div><div class="player-config-save"><a href="javascript:;" class="local">%s</a></div></div>',
            $this->elHidden, $this->elSelect, ___('Edit'), ___('Delete Preset'), ___('Save As Preset')) .
        "<script type='text/javascript'>
             $('.player-config').playerConfig();
         </script>";
    }

    protected function addPresets(HTML_QuickForm2_Element_Select $select)
    {
        $result = array();
        $presets = Am_Di::getInstance()->store->getBlob('flowplayer-presets');
        $presets = $presets ? unserialize($presets) : array();
        foreach ($presets as $id => $preset) {
            $select->addOption($preset['name'], $id, array('data-config' => serialize($preset['config'])));
        }
    }

}

class Am_Form_Element_DownloadLimit extends HTML_QuickForm2_Element
{

    protected $value = array();
    /* @var HTML_QuickForm2_Element_InputText */
    protected $elText;
    /* @var HTML_QuickForm2_Element_Select */
    protected $elSelect;
    /* @var Am_Form_Element_AdvCheckbox */
    protected $elCheckbox;

    public function __construct($name = null, $attributes = null, array $data = array())
    {

        $this->elText = new HTML_QuickForm2_Element_InputText("__limit_" . $name, array('class' => 'download-limit-limit', 'size' => 4));
        $this->elText->setValue(5); //Default

        $this->elSelect = new HTML_QuickForm2_Element_Select("__period_" . $name, array('class' => 'download-limit-period'));
        $this->elSelect->loadOptions(array(
            FileDownloadTable::PERIOD_HOUR => ___('Hour'),
            FileDownloadTable::PERIOD_DAY => ___('Day'),
            FileDownloadTable::PERIOD_WEEK => ___('Week'),
            FileDownloadTable::PERIOD_MONTH => ___('Month'),
            FileDownloadTable::PERIOD_YEAR => ___('Year'),
            FileDownloadTable::PERIOD_ALL => ___('All Subscription Period')
            )
        )->setValue(FileDownloadTable::PERIOD_MONTH); //Default

        $this->elCheckbox = new Am_Form_Element_AdvCheckbox("__enable_" . $name, array('class' => 'download-limit-enable'));

        parent::__construct($name, $attributes, $data);
    }

    public function getType()
    {
        return 'download-limit';
    }

    public function updateValue()
    {
        $this->elText->setContainer($this->getContainer());
        $this->elText->updateValue();
        $this->elSelect->setContainer($this->getContainer());
        $this->elSelect->updateValue();
        $this->elCheckbox->setContainer($this->getContainer());
        $this->elCheckbox->updateValue();
        parent::updateValue();
    }

    public function getRawValue()
    {
        return $this->elCheckbox->getValue() ? sprintf('%d:%d', $this->elText->getValue(), $this->elSelect->getValue()) : '';
    }

    public function setValue($value)
    {
        if (!$value) {
            $this->elCheckbox->setValue(0);
        } else {
            $this->elCheckbox->setValue(1);
            list($limit, $period) = explode(':', $value);
            $this->elText->setValue($limit);
            $this->elSelect->setValue($period);
        }
    }

    public function __toString()
    {
        $name = Am_Controller::escape($this->getName());

        $ret = "<div class='download-limit' id='downlod-limit-$name'>\n";
        $ret .= $this->elCheckbox;
        $ret .= ' <span>';
        $ret .= ___('allow max');
        $ret .= ' ' . (string) $this->elText . ' ';
        $ret .= ___('downloads within');
        $ret .= ' ' . (string) $this->elSelect . ' ';
        $ret .= ___('during subscription period');
        $ret .= "</span>\n";
        $ret .= "</div>";
        $ret .= "
        <script type='text/javascript'>
             $('.download-limit').find('input[type=checkbox]').change(function(){
                $(this).next().toggle(this.checked)
             }).change();
        </script>
        ";
        return $ret;
    }

}

class Am_Form_Element_ResourceAccess extends HTML_QuickForm2_Element
{

    protected $value = array();

    public function getType()
    {
        return 'resource-access';
    }

    public function getRawValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        $name = Am_Controller::escape($this->getName());
        $ret = "<div class='resourceaccess' id='$name'>";

        if (!$this->getAttribute('without_free')) {
            $ret .= "<span class='free-switch protected-access'>\n";
            $ret .= ___('Choose Products and/or Product Categories that allows access') . "<br />\n";
            $ret .= ___('or %smake access free%s', "<a href='javascript:' data-access='free' class='local'>", '</a>') . "<br /><br />\n";
        }

        $select = new HTML_QuickForm2_Element_Select(null, array('class' => 'access-items am-combobox-fixed'));
        $select->addOption(___('Please select an item...'), '');
        $g = $select->addOptgroup(___('Product Categories'), array('class' => 'product_category_id', 'data-text' => ___("Category")));
        $g->addOption(___('Any Product'), '-1', array('style' => 'font-weight: bold'));
        foreach (Am_Di::getInstance()->productCategoryTable->getAdminSelectOptions() as $k => $v) {
            $g->addOption($v, $k);
        }
        $g = $select->addOptgroup(___('Products'), array('class' => 'product_id', 'data-text' => ___("Product")));
        foreach (Am_Di::getInstance()->productTable->getOptions() as $k => $v) {
            $g->addOption($v, $k);
        }
        $ret .= (string) $select;

        foreach (Am_Di::getInstance()->resourceAccessTable->getFnValues() as $k)
            $ret .= "<div class='$k-list'></div>";

        $ret .= "</span>\n";

        $hide_free_without_login = (bool) $this->getAttribute('without_free_without_login');

        $ret .= "<span class='free-switch free-access' style='display:none;'>" .
            nl2br(___("this item is available for %sall registered customers%s.\n"
                    . "click to %smake this item protected%s\n"
                    . "%sor %smake this item available without login and registration%s\n%s"
                    , "<b>", "</b>"
                    , "<a href='javascript:;' data-access='protected' class='local'>", "</a>"
                    , ($hide_free_without_login ? '<span style="display:none">' : '<span>')
                    , "<a href='javascript:;' data-access='free_without_login' class='local'>", "</a>", '</span>')) .
            "</span>";

        $ret .= "<span class='free-switch free_without_login-access' style='display:none;'>" .
            nl2br(___("this item is available for %sall visitors (without log-in and registration) and for all members%s\n"
                    . "click to %smake this item protected%s\n"
                    . "or %smake log-in required%s\n"
                    , "<b>", "</b>"
                    , "<a href='javascript:;' data-access='protected' class='local'>", "</a>"
                    , "<a href='javascript:;' data-access='free' class='local'>", "</a>")) .
            "</span>";

        $json = array();
        if (
            !empty($this->value['product_category_id'])
            || !empty($this->value['product_id'])
            || !empty($this->value['free'])
            || !empty($this->value['free_without_login'])
        ) {
            $json = $this->value;
            foreach ($json as & $fn)
                foreach ($fn as & $rec) {
                    if (is_string($rec))
                        $rec = json_decode($rec, true);
                }
        } else
            foreach ($this->value as $cl => $access) {
                $json[$access->getClass()][$access->getId()] = array(
                    'text' => $access->getTitle(),
                    'start' => $access->getStart(),
                    'stop' => $access->getStop(false),
                );
            }

        $json = Am_Controller::escape(Am_Controller::getJson($json));
        $ret .= "<input type='hidden' class='resourceaccess-init' value='$json' />\n";
        $ret .= "</div>";

        $without_period = $this->getAttribute('without_period') ? 'true' : 'false';
        $ret .= "
        <script type='text/javascript'>
             $('#$name.resourceaccess').resourceaccess({without_period: $without_period});
        </script>
        ";
        return $ret;
    }

}

class Am_Grid_Editable_Files extends Am_Grid_Editable_Content
{

    public function __construct(Am_Request $request, Am_View $view)
    {
        parent::__construct($request, $view);
        $this->addCallback(self::CB_AFTER_DELETE, array($this, 'afterDelete'));
        $this->addCallback(self::CB_AFTER_SAVE, array($this, 'dropCache'));
        $this->addCallback(self::CB_AFTER_DELETE, array($this, 'dropCache'));
        $this->addCallback(self::CB_VALUES_FROM_FORM, array($this, '_valuesFromForm'));
        $this->setFilter(new Am_Grid_Filter_Text(___('Filter by Title'), array('title' => 'LIKE')));
    }

    public function _valuesFromForm(& $values)
    {
        $path = $values['path'];
        $values['mime'] = is_numeric($path) ?
            $this->getDi()->uploadTable->load($path)->getType() :
            Upload::getMimeType($path);
    }

    public function _valuesToForm(array & $values, Am_Record $record)
    {
        if ($record->isLoaded()) {
            $values['_category'] = $record->getCategories();
        }
        parent::_valuesToForm($values, $record);
    }

    public function afterInsert(array & $values, ResourceAbstract $record)
    {
        $record->setCategories(empty($values['_category']) ? array() : $values['_category']);
        parent::afterInsert($values, $record);
    }

    protected function dropCache()
    {
        $this->getDi()->cache->clean();
    }

    protected function afterDelete(File $record, $grid)
    {
        if (ctype_digit($record->path)
            && !$this->getDi()->fileTable->countBy(array('path' => $record->path))) {
            $this->getDi()->uploadTable->load($record->path)->delete();
        }
    }

    public function initActions()
    {
        parent::initActions();
        $this->actionAdd(new Am_Grid_Action_Group_ContentAssignCategory(false));
        $this->actionAdd(new Am_Grid_Action_Group_ContentAssignCategory(true));
    }

    protected function initGridFields()
    {
        $this->addField('title', ___('Title'))->setRenderFunction(array($this, 'renderAccessTitle'));
        $this->addField('path', ___('Filename'))->setRenderFunction(array($this, 'renderPath'));
        if ($this->getDi()->db->selectCell("SELECT COUNT(*) FROM ?_resource_resource_category WHERE resource_type=?", 'file')) {
            $this->addField(new Am_Grid_Field('rgroup', ___('Categories'), false))->setRenderFunction(array($this, 'renderCategory'));
        }
        parent::initGridFields();
    }

    protected function createAdapter()
    {
        return new Am_Query(Am_Di::getInstance()->fileTable);
    }

    function createForm()
    {
        $form = new Am_Form_Admin;
        $form->setAttribute('enctype', 'multipart/form-data');
        $form->setAttribute('target', '_top');

        $maxFileSize = min(ini_get('post_max_size'), ini_get('upload_max_filesize'));
        $el = $form->addElement(new Am_Form_Element_Upload('path', array(), array('prefix' => 'downloads')))
                ->setLabel(___("File\n(max filesize %s)", $maxFileSize))->setId('form-path');

        $jsOptions = <<<CUT
{
    onFileAdd : function (info) {
        var txt = $(this).closest("form").find("input[name='title']");
        if (txt.data('changed-value')) return;
        txt.val(info.name);
    }
}
CUT;
        $el->setJsOptions($jsOptions);
        $form->addScript()->setScript(<<<CUT
$(function(){
    $("input[name='title']").change(function(){
        $(this).data('changed-value', true);
    });
});
CUT
        );


        $el->addRule('required', ___('File is required'));
        $form->addText('title', array('class' => 'el-wide'))->setLabel(___('Title'))->addRule('required', 'This field is required');
        $form->addText('desc', array('class' => 'el-wide'))->setLabel(___('Description'));
        $form->addAdvCheckbox('hide')->setLabel(___("Hide\n" . "do not display this item link in members area"));
        $form->addElement(new Am_Form_Element_DownloadLimit('download_limit'))->setLabel(___('Limit Downloads Count'));
        $form->addElement(new Am_Form_Element_ResourceAccess)->setName('_access')->setLabel(___('Access Permissions'));
        $form->addText('no_access_url', array('class' => 'el-wide'))
            ->setLabel(___("No Access URL\ncustomer without required access will be redirected to this url\nleave empty if you want to redirect to default 'No access' page"));

        $this->addCategoryToForm($form);

        return $form;
    }

}

class Am_Grid_Editable_Pages extends Am_Grid_Editable_Content
{

    public function __construct(Am_Request $request, Am_View $view)
    {
        parent::__construct($request, $view);
        $this->addCallback(self::CB_VALUES_FROM_FORM, array($this, '_valuesFromForm'));
        $this->setFilter(new Am_Grid_Filter_Text(___('Filter by Title'), array('title' => 'LIKE')));
    }

    public function _valuesToForm(array & $values, Am_Record $record)
    {
        if ($record->isLoaded()) {
            $values['_category'] = $record->getCategories();
        }
        parent::_valuesToForm($values, $record);
    }

    public function afterInsert(array & $values, ResourceAbstract $record)
    {
        $record->setCategories(empty($values['_category']) ? array() : $values['_category']);
        parent::afterInsert($values, $record);
    }

    public function initActions()
    {
        parent::initActions();
        $this->actionAdd(new Am_Grid_Action_PagePreview('preview', ___('Preview')));
        $this->actionAdd(new Am_Grid_Action_Group_ContentAssignCategory(false));
        $this->actionAdd(new Am_Grid_Action_Group_ContentAssignCategory(true));
    }

    protected function initGridFields()
    {
        $this->addField('title', ___('Title'))->setRenderFunction(array($this, 'renderAccessTitle'));
        if ($this->getDi()->db->selectCell("SELECT COUNT(*) FROM ?_resource_resource_category WHERE resource_type=?", 'page')) {
            $this->addField(new Am_Grid_Field('rgroup', ___('Categories'), false))->setRenderFunction(array($this, 'renderCategory'));
        }
        parent::initGridFields();
    }

    protected function createAdapter()
    {
        return new Am_Query(Am_Di::getInstance()->pageTable);
    }

    function createForm()
    {
        $form = new Am_Form_Admin;

        $form->addText('title', array('class' => 'el-wide'))->setLabel(___('Title'))->addRule('required', 'This field is required');
        $form->addText('desc', array('class' => 'el-wide'))->setLabel(___('Description'));
        $form->addText('path', array('class' => 'el-wide'))
            ->setId('page-path')
            ->setLabel(array(___('Path'), ___('will be used to construct user-friendly url, in case of you leave it empty aMember will use id of this page to do it')));

        $root_url = Am_Controller::escape(Am_Di::getInstance()->config->get('root_url'));

        $form->addStatic()
            ->setLabel(___('Permalink'))
            ->setContent(<<<CUT
<div data-root_url="$root_url" id="page-permalink"></div>
CUT
        );

        $form->addScript()
            ->setScript(<<<CUT
$('#page-path').bind('keyup', function(){
    $('#page-permalink').closest('.row').toggle($(this).val() != '');
    $('#page-permalink').html($('#page-permalink').data('root_url') + '/page/' + encodeURIComponent($(this).val()).replace(/%20/g, '+'))
}).trigger('keyup')
CUT
        );

        $form->addAdvCheckbox('hide')->setLabel(___("Hide\n" . "do not display this item link in members area"));

        $placeholder_items =& $options['placeholder_items'];
        foreach ($this->getUserTagOptions() as $k => $v) {
            $placeholder_items[] = array($v, $k);
        }

        $form->addHtmlEditor('html')
            ->setMceOptions($options);

        $form->addAdvCheckbox('use_layout')
            ->setId('use-layout')
            ->setLabel(___("Display inside layout\nWhen displaying to customer, will the\nheader/footer from current theme be displayed?"));
        $form->addSelect('tpl')
            ->setId('use-layout-tpl')
            ->setLabel(___("Template\nalternative template for this page") .
                "\n" .
                ___("aMember will look for templates in [application/default/views/] folder\n" .
                    "and in theme's [/] folder\n" .
                    "and template filename must start with [layout]"))
            ->loadOptions($this->getTemplateOptions());
        $form->addScript()
            ->setScript(<<<CUT
$('#use-layout').change(function(){
    $('#use-layout-tpl').closest('.row').toggle(this.checked);
}).change()
CUT
        );

        $form->addElement(new Am_Form_Element_ResourceAccess)->setName('_access')->setLabel(___('Access Permissions'));
        $form->addText('no_access_url', array('class' => 'el-wide'))
            ->setLabel(___("No Access URL\ncustomer without required access will be redirected to this url\nleave empty if you want to redirect to default 'No access' page"));

        $this->addCategoryToForm($form);

        $fs = $form->addAdvFieldset('meta', array('id'=>'meta'))
                ->setLabel(___('Meta Data'));

        $fs->addText('meta_title', array('class' => 'el-wide'))
            ->setLabel(___('Title'));

        $fs->addText('meta_keywords', array('class' => 'el-wide'))
            ->setLabel(___('Keywords'));

        $fs->addText('meta_description', array('class' => 'el-wide'))
            ->setLabel(___('Description'));

        return $form;
    }

    function getUserTagOptions()
    {
        $tagOptions = array(
                '%user.name_f%' => 'User First Name',
                '%user.name_l%' => 'User Last Name',
                '%user.login%' => 'Username',
                '%user.email%' => 'E-Mail',
                '%user.user_id%' => 'User Internal ID#',
                '%user.street%' => 'User Street',
                '%user.street2%' => 'User Street (Second Line)',
                '%user.city%' => 'User City',
                '%user.state%' => 'User State',
                '%user.zip%' => 'User ZIP',
                '%user.country%' => 'User Country',
                '%user.status%' => 'User Status (0-pending, 1-active, 2-expired)'
        );

        foreach ($this->getDi()->userTable->customFields()->getAll() as $field) {
            if (@$field->sql && @$field->from_config) {
                $tagOptions['%user.' . $field->name . '%'] = 'User ' . $field->title;
            }
        }

        return $tagOptions;
    }

    function _valuesFromForm(& $vals, $record)
    {
        if (!$vals['path'])
            $vals['path'] = null;
        if (!$vals['tpl'])
            $vals['tpl'] = null;
    }

}

class Am_Grid_Editable_Links extends Am_Grid_Editable_Content
{

    public function __construct(Am_Request $request, Am_View $view)
    {
        parent::__construct($request, $view);
        $this->setFilter(new Am_Grid_Filter_Text(___('Filter by Title'), array('title' => 'LIKE')));
    }

    public function initActions()
    {
        parent::initActions();
        $this->actionAdd(new Am_Grid_Action_Group_ContentAssignCategory(false));
        $this->actionAdd(new Am_Grid_Action_Group_ContentAssignCategory(true));
    }

    protected function initGridFields()
    {
        $this->addField('title', ___('Title'))->setRenderFunction(array($this, 'renderAccessTitle'));
        if ($this->getDi()->db->selectCell("SELECT COUNT(*) FROM ?_resource_resource_category WHERE resource_type=?", 'link')) {
            $this->addField(new Am_Grid_Field('rgroup', ___('Categories'), false))->setRenderFunction(array($this, 'renderCategory'));
        }
        parent::initGridFields();
    }

    protected function createAdapter()
    {
        return new Am_Query(Am_Di::getInstance()->linkTable);
    }

    public function _valuesToForm(array & $values, Am_Record $record)
    {
        if ($record->isLoaded()) {
            $values['_category'] = $record->getCategories();
        }
        parent::_valuesToForm($values, $record);
    }

    public function afterInsert(array & $values, ResourceAbstract $record)
    {
        $record->setCategories(empty($values['_category']) ? array() : $values['_category']);
        parent::afterInsert($values, $record);
    }

    function createForm()
    {
        $form = new Am_Form_Admin;

        $form->addText('title', array('class' => 'el-wide'))->setLabel(___('Title'))->addRule('required');
        $form->addText('desc', array('class' => 'el-wide'))->setLabel(___('Description'));
        $form->addText('url', array('class' => 'el-wide'))->setLabel(___('URL'))->addRule('required');
        $form->addAdvCheckbox('hide')->setLabel(___("Hide\n" . "do not display this item link in members area"));
        $form->addElement(new Am_Form_Element_ResourceAccess)->setName('_access')
            ->setLabel(___('Access Permissions'))
            ->setAttribute('without_free_without_login', 'true');

        $this->addCategoryToForm($form);

        return $form;
    }

    public function renderContent()
    {
        return '<div class="info"><strong>' . ___("IMPORTANT NOTE: This will not protect content. If someone know link url, he will be able to open link without a problem. This just control what additional links user will see after login to member's area.") . '</strong></div>' . parent::renderContent();
    }

}

class Am_Grid_Editable_Integrations extends Am_Grid_Editable_Content
{

    public function __construct(Am_Request $request, Am_View $view)
    {
        parent::__construct($request, $view);
        $this->setFilter(new Am_Grid_Filter_Text(___('Filter by Plugin'), array('plugin' => 'LIKE')));
    }

    public function init()
    {
        parent::init();
        $this->addCallback(self::CB_VALUES_FROM_FORM, array($this, '_valuesFromForm'));
    }

    public function createAdapter()
    {
        return new Am_Query(Am_Di::getInstance()->integrationTable);
    }

    protected function initGridFields()
    {
        $this->addField('plugin', ___('Plugin'))->setRenderFunction(array($this, 'renderPluginTitle'));
        $this->addField('resource', ___('Resource'), false)->setRenderFunction(array($this, 'renderResourceTitle'));
        parent::initGridFields();
        $this->removeField('_link');
    }

    public function renderPluginTitle(Am_Record $r)
    {
        return $this->renderTd($r->plugin);
    }

    public function renderResourceTitle(Am_Record $r)
    {
        try {
            $pl = Am_Di::getInstance()->plugins_protect->get($r->plugin);
        } catch (Am_Exception_InternalError $e) {
            $pl = null;
        }
        $config = unserialize($r->vars);
        $s = $pl ? $pl->getIntegrationSettingDescription($config) : Am_Protect_Abstract::static_getIntegrationDescription($config);
        return $this->renderTd($s);
    }

    public function getGridPageTitle()
    {
        return ___("Integration plugins");
    }

    function createForm()
    {
        $form = new Am_Form_Admin;
        $plugins = $form->addSelect('plugin')->setLabel(___('Plugin'));
        $plugins->addRule('required');
        $plugins->addOption('*** ' . ___('Select a plugin') . ' ***', '');
        foreach (Am_Di::getInstance()->plugins_protect->getAllEnabled() as $plugin) {
            if (!$plugin->isConfigured())
                continue;
            $group = $form->addFieldset($plugin->getId())->setId('headrow-' . $plugin->getId());
            $group->setLabel($plugin->getTitle());
            $plugin->getIntegrationFormElements($group);
            // add id[...] around the element name
            foreach ($group->getElements() as $el)
                $el->setName('_plugins[' . $plugin->getId() . '][' . $el->getName() . ']');
            if (!$group->count())
                $form->removeChild($group);
            else
                $plugins->addOption($plugin->getTitle(), $plugin->getId());
        }
        $group = $form->addFieldset('access')->setLabel(___('Access'));
        $group->addElement(new Am_Form_Element_ResourceAccess)
            ->setName('_access')
            ->setLabel(___('Access Permissions'))
            ->setAttribute('without_period', 'true')
            ->setAttribute('without_free', 'true')
            ->setAttribute('without_free_without_login', 'true');

        $form->addScript()->setScript(<<<CUT
$(function(){
    $("select[name='plugin']").change(function(){
        var selected = $(this).val();
        $("[id^='headrow-']").hide();
        if (selected) {
            $("[id=headrow-"+selected+"-legend]").show();
            $("[id=headrow-"+selected+"]").show();
        }
    }).change();
});
CUT
        );
        return $form;
    }

    public function _valuesFromForm(array & $vars)
    {
        if ($vars['plugin'] && !empty($vars['_plugins'][$vars['plugin']]))
            $vars['vars'] = serialize($vars['_plugins'][$vars['plugin']]);
    }

    public function _valuesToForm(array & $vars, Am_Record $record)
    {
        if (!empty($vars['vars'])) {
            foreach (unserialize($vars['vars']) as $k => $v)
                $vars['_plugins'][$vars['plugin']][$k] = $v;
        }
        parent::_valuesToForm($vars, $record);
    }

}

class Am_Grid_Editable_Folders extends Am_Grid_Editable_Content
{

    public function __construct(Am_Request $request, Am_View $view)
    {
        parent::__construct($request, $view);
        $this->setFilter(new Am_Grid_Filter_Content_Folder());
    }

    public function _valuesToForm(array & $values, Am_Record $record)
    {
        if ($record->isLoaded()) {
            $values['_category'] = $record->getCategories();
        }
        parent::_valuesToForm($values, $record);
    }

    public function init()
    {
        parent::init();
        $this->addCallback(self::CB_AFTER_UPDATE, array($this, 'afterUpdate'));
        $this->addCallback(self::CB_AFTER_DELETE, array($this, 'afterDelete'));
    }

    public function validatePath($path)
    {
        if (!is_dir($path))
            return ___('Wrong path: not a folder: %s', htmlentities($path));
        if (!is_writeable($path))
            return ___('Specified folder is not writable - please chmod the folder to 777, so aMember can write .htaccess file for folder protection');
        if ((!$this->getRecord()->isLoaded() || $this->getRecord()->path != $path) &&
            $this->getDi()->folderTable->findFirstByPath($path))
            return ___('Specified folder is already protected. Please alter existing record or choose another folder.');
    }

    function createForm()
    {
        $form = new Am_Form_Admin;

        $title = $form->addText('title', array('class' => 'el-wide'))->setLabel(___("Title\ndisplayed to customers"));
        $title->addRule('required');
        $form->addText('desc', array('class' => 'el-wide'))->setLabel(___('Description'));
        $form->addAdvCheckbox('hide')->setLabel(___("Hide\n" . "do not display this item link in members area"));

        $path = $form->addText('path')->setLabel(___('Path to Folder'))->setAttribute('size', 50)->addClass('dir-browser');
        $path->addRule('required');
        $path->addRule('callback2', '-- Wrong path --', array($this, 'validatePath'));

        $url = $form->addGroup()->setLabel(___('Folder URL'));
        $url->addRule('required');
        $url->addText('url')->setAttribute('size', 50)->setId('url');
        $url->addHtml()->setHtml(' <a href="#" id="test-url-link">' . ___('open in new window') . '</a>');

        $methods = array(
            'new-rewrite' => ___('New Rewrite'),
            'htpasswd' => ___('Traditional .htpasswd'),
        );
        foreach ($methods as $k => $v)
            if (!Am_Di::getInstance()->plugins_protect->isEnabled($k))
                unset($methods[$k]);


        $method = $form->addAdvRadio('method')->setLabel(___('Protection Method'));
        $method->loadOptions($methods);
        if (count($methods) == 0) {
            throw new Am_Exception_InputError(___('No protection plugins enabled, please enable new-rewrite or htpasswd at aMember CP -> Setup -> Plugins'));
        } elseif (count($methods) == 1) {
            $method->setValue(key($methods))->toggleFrozen(true);
        }

        $form->addElement(new Am_Form_Element_ResourceAccess)
            ->setName('_access')
            ->setLabel(___('Access Permissions'))
            ->setAttribute('without_free_without_login', 'true');
        $form->addScript('script')->setScript('
        $(function(){
            $(".dir-browser").dirBrowser({
                urlField : "#url",
                rootUrl  : ' . Am_Controller::getJson(REL_ROOT_URL) . ',
            });
            $("#test-url-link").click(function() {
                var href = $("input", $(this).parent()).val();
                if (href)
                    window.open(href , "test-url", "");
            });
        });
        ');
        $form->addText('no_access_url', array('class' => 'el-wide'))
            ->setLabel(___("No Access URL\ncustomer without required access will be redirected to this url\nleave empty if you want to redirect to default 'No access' page"));

        $this->addCategoryToForm($form);

        return $form;
    }

    public function initActions()
    {
        parent::initActions();
        $this->actionAdd(new Am_Grid_Action_Group_ContentAssignCategory(false));
        $this->actionAdd(new Am_Grid_Action_Group_ContentAssignCategory(true));
    }

    protected function initGridFields()
    {
        $this->addField('title', ___('Title'))->setRenderFunction(array($this, 'renderAccessTitle'));
        $this->addField('path', ___('Path/URL'))->setRenderFunction(array($this, 'renderPathUrl'));
        $this->addField('method', ___('Protection Method'));
        if ($this->getDi()->db->selectCell("SELECT COUNT(*) FROM ?_resource_resource_category WHERE resource_type=?", 'folder')) {
            $this->addField(new Am_Grid_Field('rgroup', ___('Categories'), false))->setRenderFunction(array($this, 'renderCategory'));
        }
        parent::initGridFields();
    }

    public function renderPathUrl(Folder $f)
    {
        $url = Am_Controller::escape($f->url);
        return $this->renderTd(
            Am_Controller::escape($f->path) .
            "<br />" .
            "<a href='$url' class='link' target='_blank'>$url</a>", false);
    }

    protected function createAdapter()
    {
        return new Am_Query(Am_Di::getInstance()->folderTable);
    }

    public function getGridPageTitle()
    {
        return ___("Folders");
    }

    public function getHtaccessRewriteFile(Folder $folder)
    {
        if (AM_WIN)
            $rd = str_replace("\\", '/', DATA_DIR);
        else
            $rd = DATA_DIR;

        $root_url = ROOT_SURL;
        $no_access_rule = 'RewriteRule ^(.*)$ ' .
            (!empty($folder->no_access_url) ?
                $folder->no_access_url :
                "$root_url/no-access/folder/id/{$folder->folder_id}?url=%{REQUEST_URI}?%{QUERY_STRING}&host=%{HTTP_HOST}&ssl=%{HTTPS}") .
            ' [L,R]';
        // B flag requires APACHE 2.2
        // older version causes 500 error code
        // define('AMEMBER_OLD_APACHE',true); can be added into config.php
        if(!defined('AMEMBER_OLD_APACHE'))
            $bflag = <<<BFLN
RewriteRule ^(.*)$ $root_url/protect/new-rewrite?f=$folder->folder_id&url=%{REQUEST_URI}?%1&host=%{HTTP_HOST}&ssl=%{HTTPS} [L,R,B]
BFLN;
        else
            $bflag = <<<BFLO
RewriteRule ^(.*)$ $root_url/protect/new-rewrite?f=$folder->folder_id&url=%{REQUEST_URI}?%{QUERY_STRING}&host=%{HTTP_HOST}&ssl=%{HTTPS} [L,R]
BFLO;
        return <<<CUT
########### AMEMBER START #####################
Options +FollowSymLinks
RewriteEngine On

# if cookie is set and file exists, stop rewriting and show page
RewriteCond %{HTTP_COOKIE} amember_nr=([a-zA-Z0-9]+)
RewriteCond $rd/new-rewrite/%1-{$folder->folder_id} -f
RewriteRule ^(.*)\$ - [S=3]

# if cookie is set but folder file does not exists, user has no access to given folder
RewriteCond %{HTTP_COOKIE} amember_nr=([a-zA-Z0-9]+)
RewriteCond $rd/new-rewrite/%1-{$folder->folder_id} !-f
$no_access_rule

## if user is not authorized, redirect to login page
# BrowserMatch "MSIE" force-no-vary
RewriteCond %{QUERY_STRING} (.+)
$bflag
RewriteRule ^(.*)$ $root_url/protect/new-rewrite?f=$folder->folder_id&url=%{REQUEST_URI}&host=%{HTTP_HOST}&ssl=%{HTTPS} [L,R]
########### AMEMBER FINISH ####################
CUT;
    }

    public function getHtaccessHtpasswdFile(Folder $folder)
    {
        $rd = DATA_DIR;

        $require = '';
        if (!$folder->hasAnyProducts())
            $require = 'valid-user';
        else
            $require = 'group FOLDER_' . $folder->folder_id;

//        $redirect = ROOT_SURL . "/no-access?folder_id={$folder->folder_id}";
//        ErrorDocument 401 $redirect

        return <<<CUT
########### AMEMBER START #####################
AuthType Basic
AuthName "Members Only"
AuthUserFile $rd/.htpasswd
AuthGroupFile $rd/.htgroup
Require $require
########### AMEMBER FINISH ####################

CUT;
    }

    public function protectFolder(Folder $folder)
    {
        switch ($folder->method) {
            case 'new-rewrite':
                $ht = $this->getHtaccessRewriteFile($folder);
                break;
            case 'htpasswd':
                $ht = $this->getHtaccessHtpasswdFile($folder);
                break;
            default: throw new Am_Exception_InternalError(___('Unknown protection method'));
        }
        $htaccess_path = $folder->path . '/' . '.htaccess';
        if (file_exists($htaccess_path)) {
            $content = file_get_contents($htaccess_path);
            $new_content = preg_replace('/#+\sAMEMBER START.+AMEMBER FINISH\s#+/ms', $ht, $content, 1, $found);
            if (!$found)
                $new_content = $ht . "\n\n" . $content;
        } else {
            $new_content = $ht . "\n\n";
        }
        if (!file_put_contents($htaccess_path, $new_content))
            throw new Am_Exception_InputError(___('Could not write file [%s] - check file permissions and make sure it is writeable', $htaccess_path));
    }

    public function unprotectFolder(Folder $folder)
    {
        $htaccess_path = $folder->path . '/.htaccess';
        if (!is_dir($folder->path)) {
            trigger_error(___('Could not open folder [%s] to remove .htaccess from it. Do it manually', $folder->path), E_USER_WARNING);
            return;
        }
        $content = file_get_contents($htaccess_path);
        if (strlen($content) && !preg_match('/^\s*\#+\sAMEMBER START.+AMEMBER FINISH\s#+\s*/s', $content)) {
            trigger_error(___('File [%s] contains not only aMember code - remove it manually to unprotect folder', $htaccess_path), E_USER_WARNING);
            return;
        }
        if (!unlink($folder->path . '/.htaccess'))
            trigger_error(___('File [%s] cannot be deleted - remove it manually to unprotect folder', $htaccess_path), E_USER_WARNING);
    }

    public function afterInsert(array &$values, ResourceAbstract $record)
    {
        $record->setCategories(empty($values['_category']) ? array() : $values['_category']);
        parent::afterInsert($values, $record);
        $this->protectFolder($record);
    }

    public function afterUpdate(array &$values, ResourceAbstract $record)
    {
        $this->protectFolder($record);
    }

    public function afterDelete($record)
    {
        $this->unprotectFolder($record);
    }

    public function renderContent()
    {
        return '<div class="info">' . ___("After making any changes to htpasswd protected areas, please run [Utiltites->Rebuild Db] to refresh htpasswd file") . '</div>' . parent::renderContent();
    }

}

class Am_Grid_Editable_Emails extends Am_Grid_Editable_Content
{

    protected $comment = array();

    public function __construct(Am_Request $request, Am_View $view)
    {
        parent::__construct($request, $view);
        $this->setFilter(new Am_Grid_Filter_Text(___('Filter by Subject'), array('subject' => 'LIKE')));
    }

    public function init()
    {
        $this->comment = array(
            EmailTemplate::AUTORESPONDER =>
            ___('Autoresponder message will be automatically sent by cron job
when configured conditions met. If you set message to be sent
after payment, it will be sent immediately after payment received.
Auto-responder message will not be sent if:
<ul>
    <li>User has unsubscribed from e-mail messages</li>
</ul>'),
            EmailTemplate::EXPIRE =>
            ___('Expiration message will be sent when configured conditions met.
Additional restrictions applies to do not sent unnecessary e-mails.
Expiration message will not be sent if:
<ul>
    <li>User has other active products with the same renewal group</li>
    <li>User has unsubscribed from e-mail messages</li>
</ul>')
        );
        parent::init();
        $this->addCallback(self::CB_VALUES_FROM_FORM, array($this, '_valuesFromForm'));
    }

    public function initActions()
    {
        parent::initActions();
        $this->actionDelete('insert');
        $this->actionAdd($a0 = new Am_Grid_Action_Insert('insert-' . EmailTemplate::AUTORESPONDER, ___('New Autoresponder')));
        $a0->addUrlParam('name', EmailTemplate::AUTORESPONDER);
        $this->actionAdd($a1 = new Am_Grid_Action_Insert('insert-' . EmailTemplate::EXPIRE, ___('New Expiration E-Mail')));
        $a1->addUrlParam('name', EmailTemplate::EXPIRE);
        $this->actionAdd(new Am_Grid_Action_EmailPreview('preview', ___('Preview')));
    }

    protected function createAdapter()
    {
        $ds = new Am_Query(Am_Di::getInstance()->emailTemplateTable);
        $ds->addWhere('name IN (?a)', array(EmailTemplate::AUTORESPONDER, EmailTemplate::EXPIRE));
        return $ds;
    }

    protected function initGridFields()
    {
        $this->addField('name', ___('Name'));
        $this->addField('recipient_emails', ___('Recipients'), true, '', array($this, 'getRecipients'));
        $this->addField('day', ___('Send'))->setGetFunction(array($this, 'getDay'));
        $this->addField('subject', ___('Subject'))->addDecorator(new Am_Grid_Field_Decorator_Shorten(30));
        parent::initGridFields();
        $this->removeField('_link');
    }

    public function getDay(EmailTemplate $record)
    {
        switch ($record->name) {
            case EmailTemplate::AUTORESPONDER:
                return ($record->day > 1) ? ___("%d-th subscription day", $record->day) : ___("immediately after subscription is started");
                break;
            case EmailTemplate::EXPIRE:
                switch (true) {
                    case $record->day > 0:
                        return ___("%d days after expiration", $record->day);
                    case $record->day < 0:
                        return ___("%d days before expiration", -$record->day);
                    case $record->day == 0:
                        return ___("on expiration day");
                }
                break;
        }
    }

    public function getRecipients(EmailTemplate $record)
    {
        $recipients = array();
        if ($record->recipient_user)
            $recipients[] = "<strong>User</strong>";

        if ($record->recipient_admin)
            $recipients[] = "<strong>Admin</strong>";

        if ($record->recipient_emails)
            $recipients[] = $record->recipient_emails;

        return sprintf('<td>%s</td>', join(', ', $recipients));
    }

    public function createForm()
    {
        $form = new Am_Form_Admin;

        $record = $this->getRecord();

        $name = empty($record->name) ?
            $this->getCompleteRequest()->getFiltered('name') :
            $record->name;

        $form->addHidden('name');

        $form->addStatic()->setContent(nl2br($this->comment[$name]))->setLabel(___('Description'));

        $form->addStatic()->setLabel(___('E-Mail Type'))->setContent($name);

        $recipient = $form->addGroup(null)->setLabel(___('Recipients'));

        $recipient->addAdvCheckbox('recipient_user')
            ->setContent(___('User Email'));
        $recipient->addStatic()->setContent('<br>');
        $recipient->addAdvCheckbox('recipient_admin')
            ->setContent(___('Admin Email'));
        $recipient->addStatic()->setContent('<br>');
        $recipient->addAdvCheckbox('recipient_other', array('id' => 'checkbox-recipient-other'))
            ->setContent(___('Other'));
        $form->addText('recipient_emails', array('class' => 'el-wide', 'id' => 'input-recipient-emails', 'placeholder' => ___('Email Addresses Separated by Comma')))
            ->setLabel(___('Emails'))
            ->addRule('callback2', ___('Please enter valid e-mail addresses'), array($this, 'validateOtherEmails'));

        $form->addText('bcc', array('class' => 'el-wide', 'placeholder' => ___('Email Addresses Separated by Comma')))
            ->setLabel(___('BCC'))
            ->addRule('callback', ___('Please enter valid e-mail addresses'), array('Am_Validate', 'emails'));

        $form->addElement(new Am_Form_Element_MailEditor($name, array('upload-prefix' => 'email-messages')));
        $form->addElement(new Am_Form_Element_ResourceAccess('_access'))
            ->setAttribute('without_period', true)
            ->setLabel($name == EmailTemplate::AUTORESPONDER ? ___('Send E-Mail if customer has subscription (required)') : ___('Send E-Mail when subscription expires (required)'));

        $group = $form->addGroup()
                ->setLabel(___('Send E-Mail only if customer has no subscription (optional)'));

        $select = $group->addMagicSelect('_not_conditions', array('class'=>'am-combobox'))
                ->setAttribute('without_period', true)
                ->setAttribute('without_free', true);
        $this->addCategoriesProductsList($select);
        $group->addAdvCheckbox('not_conditions_expired')->setContent(___('check expired subscriptions too'));

        $group = $form->addGroup('day')->setLabel(___('Send E-Mail Message'));
        $options = ($name == EmailTemplate::AUTORESPONDER) ?
            array('' => ___('..th subscription day (starts from 2)'), '1' => ___('immediately after subscription is started')) :
            array('-' => ___('days before expiration'), '0' => ___('on expiration day'), '+' => ___('days after expiration'));
        ;
        $group->addInteger('count', array('size' => 3, 'id' => 'days-count'));
        $group->addSelect('type', array('id' => 'days-type'))->loadOptions($options);
        $group->addScript()->setScript(<<<CUT
$("#days-type").change(function(){
    var sel = $(this);
    if ($("input[name='name']").val() == 'autoresponder')
        $("#days-count").toggle( sel.val() != '1' );
    else
        $("#days-count").toggle( sel.val() != '0' );
}).change();
$("#checkbox-recipient-other").change(function(){
    $("#row-input-recipient-emails").toggle(this.checked);
}).change();
CUT
        );
        return $form;
    }

    function validateOtherEmails($val, $el)
    {
        $vars = $el->getContainer()->getValue();
        if ($vars['recipient_other'] == 1) {
            if (!strlen($vars['recipient_emails']))
                return ___('Please enter one or more email');
            if (!Am_Validate::emails($val))
                return ___('Please enter valid e-mail addresses');
        }
    }

    function addCategoriesProductsList(HTML_QuickForm2_Element_Select $select)
    {
        $g = $select->addOptgroup(___('Product Categories'), array('class' => 'product_category_id', 'data-text' => ___("Category")));
        $g->addOption(___('Any Product'), 'c-1', array('style' => 'font-weight: bold'));
        foreach ($this->getDi()->productCategoryTable->getAdminSelectOptions() as $k => $v) {
            $g->addOption($v, 'c' . $k);
        }
        $g = $select->addOptgroup(___('Products'), array('class' => 'product_id', 'data-text' => ___("Product")));
        foreach ($this->getDi()->productTable->getOptions() as $k => $v) {
            $g->addOption($v, 'p' . $k);
        }
    }

    public function _valuesToForm(array &$values, Am_Record $record)
    {
        parent::_valuesToForm($values, $record);
        switch (get_first(@$values['name'], @$_GET['name'])) {
            case EmailTemplate::AUTORESPONDER :
                $values['day'] = (empty($values['day']) || ($values['day'] == 1)) ?
                    array('count' => 1, 'type' => '1') :
                    array('count' => $values['day'], 'type' => '');
                break;
            case EmailTemplate::EXPIRE :
                $day = @$values['day'];
                $values['day'] = array('count' => $day, 'type' => '');
                if ($day > 0)
                    $values['day']['type'] = '+';
                elseif ($day < 0) {
                    $values['day']['type'] = '-';
                    $values['day']['count'] = -$day;
                } else
                    $values['day']['type'] = '0';
                break;
        }
        $values['attachments'] = explode(',', @$values['attachments']);
        $values['_not_conditions'] = explode(',', @$values['not_conditions']);

        if (!empty($values['recipient_emails'])) {
            $values['recipient_other'] = 1;
        }

        if (!$record->isLoaded()) {
            $values['recipient_user'] = 1;
            $values['format'] = 'html';
        }
    }

    public function _valuesFromForm(array &$values)
    {
        switch ($values['day']['type']) {
            case '0': $values['day'] = 0;
                break;
            case '1': $values['day'] = 1;
                break;
            case '': case '+':
                $values['day'] = (int) $values['day']['count'];
                break;
            case '-':
                $values['day'] = - $values['day']['count'];
                break;
        }
        $values['attachments'] = implode(',', @$values['attachments']);
        ///////
        foreach (array('free', 'free_without_login', 'product_category_id', 'product_id') as $key) {
            if (!empty($values['_access'][$key]))
                foreach ($values['_access'][$key] as & $item) {
                    if (is_string($item))
                        $item = json_decode($item, true);
                    $item['start'] = $item['stop'] = $values['day'] . 'd';
                }
        }
        $values['_not_conditions'] = array_filter(array_map('filterId', $values['_not_conditions']));
        $values['not_conditions'] = implode(',', $values['_not_conditions']);

        if (!$values['recipient_other'])
            $values['recipient_emails'] = null;
        unset($values['recipient_other']);
    }

    public function getProducts(ResourceAbstract $resource)
    {
        $s = "";
        foreach ($resource->getAccessList() as $access)
            $s .= sprintf("%s <b>%s</b> %s<br />\n", $access->getClass(), $access->getTitle(), "");
        return $s;
    }

}

class Am_Grid_Editable_Video extends Am_Grid_Editable_Content
{

    function __construct(Am_Request $request, Am_View $view)
    {
        parent::__construct($request, $view);
        $this->addCallback(self::CB_VALUES_FROM_FORM, array($this, '_valuesFromForm'));
        $this->setFilter(new Am_Grid_Filter_Text(___('Filter by Title'), array('title' => 'LIKE')));
    }

    public function initActions()
    {
        parent::initActions();
        $this->actionAdd(new Am_Grid_Action_Group_ContentAssignCategory(false));
        $this->actionAdd(new Am_Grid_Action_Group_ContentAssignCategory(true));
    }

    protected function initGridFields()
    {
        $this->addField('title', ___('Title'))->setRenderFunction(array($this, 'renderAccessTitle'));
        $this->addField('path', ___('Filename'))->setRenderFunction(array($this, 'renderPath'));
        if ($this->getDi()->db->selectCell("SELECT COUNT(*) FROM ?_resource_resource_category WHERE resource_type=?", 'video')) {
            $this->addField(new Am_Grid_Field('rgroup', ___('Categories'), false))->setRenderFunction(array($this, 'renderCategory'));
        }
        $this->addField(new Am_Grid_Field_Expandable('_code', ___('JavaScript Code')))
            ->setGetFunction(array($this, 'renderJsCode'));
        parent::initGridFields();
    }

    protected function _valuesFromForm(& $values)
    {
        $path = $values['path'];
        $values['mime'] = is_numeric($path) ?
            $this->getDi()->uploadTable->load($path)->getType() :
            Upload::getMimeType($path);
        if (!$values['tpl'])
            $values['tpl'] = null;
    }

    public function _valuesToForm(array & $values, Am_Record $record)
    {
        if ($record->isLoaded()) {
            $values['_category'] = $record->getCategories();
        }
        parent::_valuesToForm($values, $record);
    }

    public function afterInsert(array & $values, ResourceAbstract $record)
    {
        $record->setCategories(empty($values['_category']) ? array() : $values['_category']);
        parent::afterInsert($values, $record);
    }

    public function renderJsCode(Video $video)
    {
        $type = $video->mime == 'audio/mpeg' ? 'audio' : 'video';

        $width = 550;
        $height = $type == 'video' ? 330 : 30;

        $root = Am_Controller::escape(ROOT_URL);
        $cnt = <<<CUT
<!-- the following code you may insert into any HTML, PHP page of your website or into WP post -->
<!-- you may skip including Jquery library if that is already included on your page -->
<script type="text/javascript"
        src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<!-- end of JQuery include -->
<!-- there is aMember video JS code starts -->
<!-- you can use GET variable width and height in src URL below
     to customize these params for specific entity
     eg. $root/$type/js/id/{$video->video_id}?width=$width&height=$height -->
<script type="text/javascript" id="am-$type-{$video->video_id}"
    src="$root/$type/js/id/{$video->video_id}">
</script>
<!-- end of aMember video JS code -->
CUT;
        return "<pre>" . Am_Controller::escape($cnt) . "</pre>";
    }

    protected function createAdapter()
    {
        return new Am_Query(Am_Di::getInstance()->videoTable);
    }

    function createForm()
    {
        $form = new Am_Form_Admin;
        $form->setAttribute('enctype', 'multipart/form-data');
        $form->setAttribute('target', '_top');

        $maxFileSize = min(ini_get('post_max_size'), ini_get('upload_max_filesize'));
        $el = $form->addElement(new Am_Form_Element_Upload('path', array(), array('prefix' => 'video')))
                ->setLabel(___("Video/Audio File\n".
            "(max upload size %s)\n".
            "You can use this feature only for video and\naudio formats that %ssupported by %s%s",
                        $maxFileSize,
                        ($this->getDi()->config->get('video_player', 'Flowplayer') == 'Flowplayer') ?
                        '<a href="http://flowplayer.org/documentation/installation/formats.html" class="link" target="_blank">' :
                        '<a href="http://www.longtailvideo.com/support/jw-player/28836/media-format-support/" class="link" target="_blank">',
                        ($this->getDi()->config->get('video_player', 'Flowplayer') == 'Flowplayer') ?
                            'Flowplayer' :
                            'JWPlayer',
                    '</a>'))
                ->setId('form-path');

        $jsOptions = <<<CUT
{
    onFileAdd : function (info) {
        var txt = $(this).closest("form").find("input[name='title']");
        if (txt.data('changed-value')) return;
        txt.val(info.name);
    }
}
CUT;
        $el->setJsOptions($jsOptions);
        $form->addScript()->setScript(<<<CUT
$(function(){
    $("input[name='title']").change(function(){
        $(this).data('changed-value', true);
    });
});
CUT
        );
        $el->addRule('required');

        $form->addUpload('poster_id', null, array('prefix' => 'video-poster'))
            ->setLabel(___("Poster Image\n" .
                "applicable only for video files"));

        $form->addText('title', array('class' => 'el-wide'))->setLabel(___('Title'))->addRule('required', 'This field is required');
        $form->addText('desc', array('class' => 'el-wide'))->setLabel(___('Description'));
        $form->addAdvCheckbox('hide')->setLabel(___("Hide\n" . "do not display this item link in members area"));

        $form->addElement(new Am_Form_Element_PlayerConfig('config'))->setLabel(array(___('Player Configuration'),
            ___('this option is applied only for video files')));

        $form->addSelect('tpl')
            ->setLabel(___("Template\nalternative template for this video") .
                "\n" .
                ___("aMember will look for templates in [application/default/views/] folder\n" .
                    "and in theme's [/] folder\n" .
                    "and template filename must start with [layout]"))
            ->loadOptions($this->getTemplateOptions());

        $form->addElement(new Am_Form_Element_ResourceAccess)->setName('_access')->setLabel(___('Access Permissions'));
        $form->addText('no_access_url', array('class' => 'el-wide'))
            ->setLabel(___("No Access URL\ncustomer without required access will see link to this url in the player window\nleave empty if you want to redirect to default 'No access' page"));

        $this->addCategoryToForm($form);

        $fs = $form->addAdvFieldset('meta', array('id'=>'meta'))
                ->setLabel(___('Meta Data'));

        $fs->addText('meta_title', array('class' => 'el-wide'))
            ->setLabel(___('Title'));

        $fs->addText('meta_keywords', array('class' => 'el-wide'))
            ->setLabel(___('Keywords'));

        $fs->addText('meta_description', array('class' => 'el-wide'))
            ->setLabel(___('Description'));

        $form->addEpilog('<div class="info">' . ___('In case of video do not start play before
full download and you use <a class="link" href="http://en.wikipedia.org/wiki/MPEG-4_Part_14">mp4 format</a>
more possible that metadata (moov atom) is located
at the end of file. There is special programs that allow to relocate
this metadata to the beginning of your file and allow play video before full
download (On Linux mashine you can use <em>qt-faststart</em> utility to do it).
Also your video editor can has option to locate metadata at beginning of file
(something like <em>FastStart</em> or <em>Web Optimized</em> option).
You need to relocate metadata for this file and reupload
it to aMember. You can use such utilites as <em>AtomicParsley</em> or similar
to check your file structure.') . '</div>');

        return $form;
    }

    public function renderContent()
    {
        return $this->getPlayerInfo() . parent::renderContent();
    }

    function getPlayerInfo()
    {
        $out = "";
        foreach (array(
        '/default/views/public/js/flowplayer/flowplayer.js',
        '/default/views/public/js/flowplayer/flowplayer.swf',
        '/default/views/public/js/flowplayer/flowplayer.controls.swf',
        '/default/views/public/js/flowplayer/flowplayer.audio.swf') as $file) {

            if (!file_exists($fn = APPLICATION_PATH . $file))
                $out .= ___('Please upload file [<i>%s</i>]<br />', $fn);
        }
        if ($out) {
            $out = '<div class="info">' . ___('To starting sharing media files, you have to download either free or commercial version of <a href="http://flowplayer.org/">FlowPlayer</a><br />')
                . $out . '</div>';
        }
        return $out;
    }

}

class Am_Grid_Editable_ContentAll extends Am_Grid_Editable
{

    public function __construct(Am_Request $request, Am_View $view)
    {
        $di = Am_Di::getInstance();

        $ds = null;
        $i = 0;
        $key = null;
        foreach ($di->resourceAccessTable->getAccessTables() as $k => $t) {
            $q = new Am_Query($t);
            $q->clearFields();
            if (empty($key))
                $key = $t->getKeyField();
            $q->addField($t->getKeyField(), $key);
            $type = $t->getAccessType();
            $q->addField("'$type'", 'resource_type');
            $q->addField($t->getTitleField(), 'title');
            $q->addField($q->escape($t->getAccessTitle()), 'type_title');
            $q->addField($q->escape($t->getPageId()), 'page_id');

            if ($t instanceof EmailTemplateTable)
                $q->addWhere('name IN (?a)', array(EmailTemplate::AUTORESPONDER, EmailTemplate::EXPIRE));
            if (empty($ds))
                $ds = $q;
            else
                $ds->addUnion($q);
        }
        // yes we need that subquery in subquery to mask field names
        // to get access of fields of main query (!)
        $ds->addOrderRaw("(SELECT _sort_order
             FROM ( SELECT sort_order as _sort_order,
                    resource_type as _resource_type,
                    resource_id as _resource_id
                  FROM ?_resource_access_sort ras) AS _ras
             WHERE _resource_id=$key AND _resource_type=resource_type LIMIT 1),
             $key, resource_type");

        parent::__construct('_all', ___('All Content'), $ds, $request, $view, $di);
        $this->addField('type_title', ___('Type'));
        $this->addField('title', ___('Title'));
        if ($this->getDi()->db->selectCell("SELECT COUNT(*) FROM ?_resource_resource_category")) {
            $this->addField(new Am_Grid_Field('rgroup', ___('Categories'), false))->setRenderFunction(array($this, 'renderCategory'));
        }

        $this->actionDelete('insert');
        $this->actionDelete('edit');
        $this->actionDelete('delete');

        $this->actionAdd(new Am_Grid_Action_ContentAllEdit('edit', ___('Edit'), ''));
        $this->actionAdd(new Am_Grid_Action_SortContent());
    }

    public function renderCategory(ResourceAbstract $e)
    {
        $res = array();
        $options = $this->getDi()->resourceCategoryTable->getOptions();
        foreach ($e->getCategories() as $resc_id) {
            $res[] = $options[$resc_id];
        }
        return $this->renderTd(implode(", ", $res));
    }

}

/**
 * This field type once added allows to sort records by dragging or by changing
 * sort number
 */
class Am_Grid_Action_SortContent extends Am_Grid_Action_Sort_Abstract
{

    protected $privilege = 'edit';

    protected function getRecordParams($obj)
    {
        $id = $obj->pk();
        $type = $obj->get('resource_type');
        if (!$type)
            $type = $this->grid->getDataSource()->createRecord()->getAccessType();

        return array(
            'id' => $id,
            'type' => $type
        );
    }

    protected function setSortBetween($item, $after, $before)
    {
        $move_after = $after ? $after['id'] : null;
        $move_after_type = $after ? $after['type'] : null;
        $move_before = $before ? $before['id'] : null;
        $move_before_type = $before ? $before['type'] : null;

        $accessTables = Am_Di::getInstance()->resourceAccessTable->getAccessTables();
        $record = $accessTables[$item['type']]->load($item['id']);

        $record->setSortBetween($move_after, $move_before, $move_after_type,
            $move_before_type);
    }

}

class Am_Grid_Action_ContentAllEdit extends Am_Grid_Action_Abstract
{

    protected $privilege = 'edit';
    protected $url;

    public function __construct($id, $title, $url)
    {
        $this->id = $id;
        $this->title = $title;
        $this->url = $url;
        parent::__construct();
        $this->setTarget('_top');
    }

    public function getUrl($record = null, $id = null)
    {
        $id = $record->pk();
        $page_id = $record->page_id;
        $back_url = Am_Controller::escape($this->grid->getBackUrl());
        return REL_ROOT_URL . "/default/admin-content/p/$page_id/index?_{$page_id}_a=edit&_{$page_id}_b=$back_url&_{$page_id}_id=$id";
    }

    public function run()
    {

    }

}

class AdminContentController extends Am_Controller_Pages
{

    public function checkAdminPermissions(Admin $admin)
    {
        return $admin->hasPermission('grid_content');
    }

    public function preDispatch()
    {
        parent::preDispatch();
        $this->view->headScript()->appendFile(REL_ROOT_URL . "/application/default/views/public/js/resourceaccess.js");
        $this->view->headScript()->appendFile(REL_ROOT_URL . "/application/default/views/public/js/player-config.js");
    }

    public function initPages()
    {
        if (empty($this->getSession()->admin_content_sort_checked)) {
            // dirty hack - we are checking that all content records have sort order
            $count = 0;
            foreach ($this->getDi()->resourceAccessTable->getAccessTables() as $k => $table)
                $count += $table->countBy();
            $countSort = $this->getDi()->db->selectCell("SELECT COUNT(*) FROM
                ?_resource_access_sort");
            if ($countSort != $count)
                $this->getDi()->resourceAccessTable->syncSortOrder();
            $this->getSession()->admin_content_sort_checked = 1;
        }
        //
        foreach ($this->getDi()->resourceAccessTable->getAccessTables() as $k => $table) {
            /* @var $table ResourceAbstractTable */
            $page_id = $table->getPageId();
            $this->addPage('Am_Grid_Editable_' . ucfirst($page_id), $page_id, $table->getAccessTitle());
        }
        $this->addPage('Am_Grid_Editable_ContentAll', 'all', ___('All'));
    }

    public function renderPage(Am_Controller_Pages_Page $page)
    {
        $this->setActiveMenu($page->getId() == 'all' ? 'content' : 'content-' . $page->getId());
        return parent::renderPage($page);
    }

}
