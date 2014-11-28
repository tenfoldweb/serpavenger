<?php

/*
 *
 *
 *     Author: Alex Scott
 *      Email: alex@cgi-central.net
 *        Web: http://www.cgi-central.net
 *    Details: New fields
 *    FileName $RCSfile$
 *    Release: 4.4.2 ($Revision$)
 *
 * Please direct bug reports,suggestions or feedback to the cgi-central forums.
 * http://www.cgi-central.net/forum/
 *
 * aMember PRO is a commercial software. Any distribution is strictly prohibited.
 *
 */

include_once dirname(__FILE__) . '/AdminContentController.php';

class Am_Form_Admin_CustomFields extends Am_Form_Admin
{
    protected $record;

    function __construct($record)
    {
        $this->record = $record;
        parent::__construct('fields');
    }

    function init()
    {
        $name = $this->addText('name')
                ->setLabel(___('Field Name'));

        if (isset($this->record->name)) {
            $name->setAttribute('disabled', 'disabled');
            $name->setValue($this->record->name);
        } else {
            $name->addRule('required');
            $name->addRule('callback', ___('Please choose another field name. This name is already used'), array($this, 'checkName'));
            $name->addRule('regex', ___('Name must be entered and it may contain lowercase letters, underscores and digits'), '/^[a-z][a-z0-9_]+$/');
        }

        $title = $this->addText('title', array('class'=>'translate'))
                ->setLabel(___('Field Title'));
        $title->addRule('required');

        $this->addTextarea('description', array('class'=>'translate'))
            ->setLabel(array(___('Field Description'),
                ___('for dispaying on signup and profile editing screen (for user)')));

        $sql = $this->addAdvRadio('sql')
                ->setLabel(array(___('Field Type'),
                    ___('sql field will be added to table structure, common field will not, we recommend you to choose second option')))
                ->loadOptions(array(
                    1 => ___('SQL (could not be used for multi-select and checkbox fields)'),
                    0 => ___('Not-SQL field (default)')))
                ->setValue(0);

        $sql->addRule('required');

        $sql_type = $this->addElement('select', 'sql_type')
                ->setLabel(array(___('SQL field type'),
                    ___('if you are unsure, choose first type (string)')))
                ->loadOptions(array(
                        '' => '-- ' . ___('Please choose') . '--',
                        'VARCHAR(255)' => ___('String') . ' (VARCHAR(255))',
                        'TEXT' => ___('Text (unlimited length string/data)'),
                        'BLOB' => ___('Blob (unlimited length binary data)'),
                        'INT' => ___('Integer field (only numbers)'),
                        'DECIMAL(12,2)' => ___('Numeric field') . ' (DECIMAL(12,2))'));

        $sql_type->addRule('callback', ___('This field is requred'), array(
                'callback' => array($this, 'checkSqlType'),
                'arguments' => array('fieldSql' => $sql)));

        $this->addAdvRadio('type')
            ->setLabel(___('Display Type'))
            ->loadOptions(array(
                    'text' => ___('Text'),
                    'select' => ___('Select (Single Value)'),
                    'multi_select' => ___('Select (Multiple Values)'),
                    'textarea' => ___('TextArea'),
                    'radio' => ___('RadioButtons'),
                    'checkbox' => ___('CheckBoxes'),
                    'date'      =>  ___('Date')
                ))
            ->setValue('text');

        $this->addElement('options_editor', 'values', array('class' => 'props'))
            ->setLabel(___('Field Values'))
            ->setValue(array(
                'options' => array(),
                'default' => array()));

        $textarea = $this->addGroup()
                ->setLabel(array('Size of textarea field', 'Columns &times; Rows'));
        $textarea->setSeparator(' ');
        $textarea->addText('cols', array('size' => 6, 'class' => 'props'))
            ->setValue(20);
        $textarea->addText('rows', array('size' => 6, 'class' => 'props'))
            ->setValue(5);

        $this->addText('size', array('class' => 'props'))
            ->setLabel(___('Size of input field'))
            ->setValue(20);

        $this->addText('default', array('class' => 'props'))
            ->setLabel(___("Default value for field\n(that is default value for inputs, not SQL DEFAULT)"));

        $el = $this->addMagicSelect('validate_func')
                ->setLabel(___('Validation'))
                ->loadOptions(array(
                    'required' => ___('Required value'),
                    'integer' => ___('Integer Value'),
                    'numeric' => ___('Numeric Value'),
                    'email' => ___('E-Mail Address')));

        $this->addElement(new Am_Form_Element_ResourceAccess)->setName('_access')
            ->setLabel(array(___('Access Permissions'),
                ___('this field will be removed from form if access permission does not match and user will not be able to update this field')));

        $jsCode = <<<CUT
(function($){
	prev_opt = null;
    $("[name=type]").click(function(){
        taggleAdditionalFields(this);
    })

    $("[name=type]:checked").each(function(){
        taggleAdditionalFields(this);
    });

    $("[name=sql]").click(function(){
        taggleSQLType(this);
    })

    $("[name=sql]:checked").each(function(){
        taggleSQLType(this);
    });

    function taggleSQLType(radio) {
        if (radio.checked && radio.value == 1) {
            $("select[name=sql_type]").closest(".row").show();
        } else {
            $("select[name=sql_type]").closest(".row").hide();
        }
    }

    function clear_sql_types(){
        var elem = $("select[name='sql_type']");
        if ((elem.val()!="TEXT")) {
            prev_opt = elem.val();
            elem.val("TEXT");
        }
    }
    function back_sql_types(){
        var elem = $("select[name='sql_type']");
        if ((elem.val()=="TEXT") && prev_opt)
            elem.val(prev_opt);
    }


    function taggleAdditionalFields(radio) {
        $(".props").closest(".row").hide();
        if ( radio.checked ) {
            switch ($(radio).val()) {
                case 'text':
                    $("input[name=size],input[name=default]").closest(".row").show();
                    back_sql_types();
                    break;
                case 'textarea':
                    $("input[name=cols],input[name=rows],input[name=default]").closest(".row").show();
                    clear_sql_types();
                    break;
                case 'date':
                    $("input[name=default]").closest(".row").show();
                    clear_sql_types();
                    break;
                case 'multi_select':
                    $("input[name=values],input[name=size]").closest(".row").show();
                    clear_sql_types();
                    break;
                case 'select':
                    $("input[name=values]").closest(".row").show();
                    clear_sql_types();
                    break;
                case 'checkbox':
                case 'radio':
                    $("input[name=values]").closest(".row").show();
                    clear_sql_types();
                break;
            }
        }
    }
})(jQuery)
CUT;

        $this->addScript()
            ->setScript($jsCode);
    }

    public function checkName($name)
    {
        $dbFields = Am_Di::getInstance()->userTable->getFields(true);
        if (in_array($name, $dbFields)) {
            return false;
        } else {
            return is_null(Am_Di::getInstance()->userTable->customFields()->get($name));
        }
    }

    public function checkSqlType($sql_type, $fieldSql)
    {
        return (!$sql_type && $fieldSql->getValue()) ? false : true;
    }

}

class Am_Grid_DataSource_CustomFields extends Am_Grid_DataSource_Array
{

    public function insertRecord($record, $valuesFromForm)
    {
        $member_fields = Am_Di::getInstance()->config->get('member_fields');
        $recordForStore = $this->getRecordForStore($valuesFromForm);
        $recordForStore['name'] = $valuesFromForm['name'];
        $member_fields[] = $recordForStore;
        Am_Config::saveValue('member_fields', $member_fields);
        Am_Di::getInstance()->config->set('member_fields', $member_fields);

        if ($recordForStore['sql'])
            $this->addSqlField($recordForStore['name'], $recordForStore['additional_fields']['sql_type']);
    }

    public function updateRecord($record, $valuesFromForm)
    {
        $member_fields = Am_Di::getInstance()->config->get('member_fields');
        foreach ($member_fields as $k => $v) {
            if ($v['name'] == $record->name) {
                $recordForStore = $this->getRecordForStore($valuesFromForm);
                $recordForStore['name'] = $record->name;
                $member_fields[$k] = $recordForStore;
            }
        }
        Am_Config::saveValue('member_fields', $member_fields);
        Am_Di::getInstance()->config->set('member_fields', $member_fields);

        if ($record->sql != $recordForStore['sql']) {
            if ($recordForStore['sql']) {
                $this->convertFieldToSql($record->name, $recordForStore['additional_fields']['sql_type']);
            } else {
                $this->convertFieldFromSql($record->name);
            }
        } elseif ($recordForStore['sql'] &&
            $record->sql_type != $recordForStore['additional_fields']['sql_type']) {

            $this->changeSqlField($record->name, $recordForStore['additional_fields']['sql_type']);
        }
    }

    public function deleteRecord($id, $record)
    {
        $record = $this->getRecord($id);
        $member_fields = Am_Di::getInstance()->config->get('member_fields');
        foreach ($member_fields as $k => $v) {
            if ($v['name'] == $record->name)
                unset($member_fields[$k]);
        }
        Am_Config::saveValue('member_fields', $member_fields);
        Am_Di::getInstance()->config->set('member_fields', $member_fields);

        if ($record->sql)
            $this->dropSqlField($record->name);
    }

    public function createRecord()
    {
        $o = new stdclass;
        $o->name = null;
        $o->options = array();
        $o->default = null;
        return $o;
    }

    protected function getRecordForStore($values)
    {
        $value = array();

        if (($values['type'] == 'text') ||
            ($values['type'] == 'textarea') ||
            ($values['type'] == 'date')) {
            $default = $values['default'];
        } else {
            $default = array_intersect($values['values']['default'], array_keys($values['values']['options']));
            if ($values['type'] == 'radio')
                $default = $default[0];
        }

        if ($values['type'] == 'select') $values['size'] = 1;

        $recordForStore['title'] = $values['title'];
        $recordForStore['description'] = $values['description'];
        $recordForStore['sql'] = $values['sql'];
        $recordForStore['type'] = $values['type'];
        $recordForStore['validate_func'] = $values['validate_func'];
        $recordForStore['additional_fields'] = array(
            'sql' => intval($values['sql']),
            'sql_type' => $values['sql_type'],
            'size' => $values['size'],
            'default' => $default,
            'options' => $values['values']['options'],
            'cols' => $values['cols'],
            'rows' => $values['rows'],
        );

        return $recordForStore;
    }

    protected function addSqlField($name, $type)
    {
        Am_Di::getInstance()->db->query("ALTER TABLE ?_user ADD ?# $type", $name);
    }

    protected function dropSqlField($name)
    {
        Am_Di::getInstance()->db->query("ALTER TABLE ?_user DROP ?#", $name);
    }

    protected function changeSqlField($name, $type)
    {
        Am_Di::getInstance()->db->query("ALTER TABLE ?_user CHANGE ?# ?# $type", $name, $name);
    }

    protected function convertFieldToSql($name, $type)
    {
        $this->addSqlField($name, $type);
        Am_Di::getInstance()->db->query("UPDATE ?_user u SET ?# = (SELECT `value`
            FROM ?_data
            WHERE `table`='user'
            AND `key`= ?
            AND `id`=u.user_id LIMIT 1)", $name, $name);
        Am_Di::getInstance()->db->query("DELETE FROM ?_data WHERE `table`='user' AND `key`=?", $name);
    }

    protected function convertFieldFromSql($name)
    {
        Am_Di::getInstance()->db->query("INSERT INTO ?_data (`table`, `key`, `id`, `value`)
            (SELECT 'user', ?, user_id, ?# FROM ?_user)", $name, $name);

        $this->dropSqlField($name);
    }

    public function getDataSourceQuery()
    {
        return null;
    }

}

class AdminFieldsController extends Am_Controller_Grid
{

    public function checkAdminPermissions(Admin $admin)
    {
        return $admin->hasPermission(Am_Auth_Admin::PERM_ADD_USER_FIELD);
    }

    public function preDispatch()
    {
        parent::preDispatch();
        $this->view->headScript()->appendFile(REL_ROOT_URL . "/application/default/views/public/js/resourceaccess.js");
    }

    public function indexAction()
    {
        Am_Di::getInstance()->userTable->syncSortOrder();
        parent::indexAction();
    }

    public function parseCsvAction()
    {
        Am_Controller::ajaxResponse(array_map('str_getcsv',array_map('trim', explode("\n", $this->getParam('csv', '')))));
    }

    public function createGrid()
    {
        $fields = Am_Di::getInstance()->userTable->customFields()->getAll();
        uksort($fields, array(Am_Di::getInstance()->userTable, 'sortCustomFields'));
        $ds = new Am_Grid_DataSource_CustomFields($fields);
        $grid = new Am_Grid_Editable('_f', ___('Additional Fields'), $ds, $this->_request, $this->view);
        $grid->addField(new Am_Grid_Field('name', ___('Name'), true, '', null, '10%'));
        $grid->addField(new Am_Grid_Field('title', ___('Title'), true, '', null, '20%'));
        $grid->addField(new Am_Grid_Field('sql', ___('Field Type'), true, '', null, '10%'))
            ->setRenderFunction(array($this, 'renderFieldType'));
        $grid->addField(new Am_Grid_Field('type', ___('Display Type'), true, '', null, '10%'));
        $grid->addField(new Am_Grid_Field('description', ___('Description'), false, '', null, '40%'));
        $grid->addField(new Am_Grid_Field('validateFunc', ___('Validation'), false, '', null, '20%'))
            ->setGetFunction(create_function('$r', 'return implode(",", (array)$r->validateFunc);'));

        $grid->setForm(array($this, 'createForm'));
        $grid->addCallback(Am_Grid_Editable::CB_VALUES_TO_FORM, array($this, 'valuesToForm'));
        $grid->addCallback(Am_Grid_Editable::CB_AFTER_DELETE, array($this, 'afterDelete'));
        $grid->addCallback(Am_Grid_Editable::CB_AFTER_SAVE, array($this, 'afterSave'));
        $grid->addCallback(Am_Grid_ReadOnly::CB_TR_ATTRIBS, array($this, 'getTrAttribs'));
        $grid->setPermissionId(Am_Auth_Admin::PERM_ADD_USER_FIELD);

        $grid->actionGet('edit')->setIsAvailableCallback(create_function('$record', 'return isset($record->from_config) && $record->from_config;'));
        $grid->actionGet('delete')->setIsAvailableCallback(create_function('$record', 'return isset($record->from_config) && $record->from_config;'));
        
        $grid->actionAdd(new Am_Grid_Action_Sort_CustomFields());
        
        $grid->setRecordTitle(___('Field'));
        return $grid;
    }

    public function renderFieldType($record, $fieldName, Am_Grid_ReadOnly $grid) {
        return $grid->renderTd(!empty($record->sql) ? '[SQL]' : '[DATA]');
    }

    public function createForm()
    {
        return new Am_Form_Admin_CustomFields($this->grid->getRecord());
    }

    public function getTrAttribs(& $ret, $record)
    {
        if (!(isset($record->from_config) && $record->from_config)) {
            $ret['class'] = isset($ret['class']) ? $ret['class'] . ' disabled' : 'disabled';
        }
    }

    public function valuesToForm(& $ret, $record)
    {
        $ret['validate_func'] = @$record->validateFunc;

        $ret['values'] = array(
            'options' => $record->options,
            'default' => $record->default
        );

        $ret['_access'] = $record->name ?
            $this->getDi()->resourceAccessTable->getAccessList(amstrtoint($record->name), Am_CustomField::ACCESS_TYPE) :
            array(
                ResourceAccess::FN_FREE_WITHOUT_LOGIN => array(
                    json_encode(array(
                        'start' => null,
                        'stop' => null,
                        'text' => ___('Free Access without log-in')
                )))
            );
    }

    public function afterSave(array & $values, $record)
    {
        $record->name = $record->name ? $record->name : $values['name'];
        $this->getDi()->resourceAccessTable->setAccess(amstrtoint($record->name), Am_CustomField::ACCESS_TYPE, $values['_access']);
    }

    public function afterDelete($record)
    {
        $this->getDi()->resourceAccessTable->clearAccess(amstrtoint($record->name), Am_CustomField::ACCESS_TYPE);

        foreach ($this->getDi()->savedFormTable->findBy() as $savedForm)
        {
            if ($row = $savedForm->findBrickById('field-' . $record->name))
            {
                $savedForm->removeBrickConfig($row['class'], $row['id']);
                $savedForm->update();
            }
        }
    }
}

class Am_Grid_Action_Sort_CustomFields extends Am_Grid_Action_Sort_Abstract
{
    protected $privilege = null;

    protected function getRecordParams($obj)
    {
        return array(
            'id' => $obj->name,
        );
    }

    protected function setSortBetween($item, $after, $before)
    {
        $after = $after ? $after['id'] : null;
        $before = $before ? $before['id'] : null;
        $id = $item['id'];

        $db = Am_Di::getInstance()->db;
        $item = $db->selectRow("SELECT *
                FROM ?_custom_field_sort
                WHERE custom_field_name=?
                AND custom_field_table=?
            ", $id, 'user');
        if ($before) {
            $beforeItem = $db->selectRow("SELECT *
                FROM ?_custom_field_sort
                WHERE custom_field_name=?
                AND custom_field_table=?
            ", $before, 'user');

            $sign = $beforeItem['sort_order'] > $item['sort_order'] ?
                '-':
                '+';

            $newSortOrder = $beforeItem['sort_order'] > $item['sort_order'] ?
                $beforeItem['sort_order']-1:
                $beforeItem['sort_order'];

            $db->query("UPDATE ?_custom_field_sort
                SET sort_order=sort_order{$sign}1 WHERE
                sort_order BETWEEN ? AND ? AND custom_field_name<>?
                AND custom_field_table=?",
                min($newSortOrder, $item['sort_order']),
                max($newSortOrder, $item['sort_order']),
                $id, 'user');

            $db->query("UPDATE ?_custom_field_sort SET sort_order=?
                WHERE custom_field_name=?
                AND custom_field_table=?",
                $newSortOrder, $id, 'user');

        } elseif ($after) {
            $afterItem = $db->selectRow("SELECT *
                FROM ?_custom_field_sort
                WHERE custom_field_name=?
                AND custom_field_table=?
            ", $after, 'user');

            $sign = $afterItem['sort_order'] > $item['sort_order'] ?
                '-':
                '+';

             $newSortOrder = $afterItem['sort_order'] > $item['sort_order'] ?
                $afterItem['sort_order']:
                $afterItem['sort_order']+1;

            $db->query("UPDATE ?_custom_field_sort
                SET sort_order=sort_order{$sign}1 WHERE
                sort_order BETWEEN ? AND ? AND custom_field_name<>?
                AND custom_field_table=?",
                min($newSortOrder, $item['sort_order']),
                max($newSortOrder, $item['sort_order']),
                $id, 'user');

            $db->query("UPDATE ?_custom_field_sort SET sort_order=?
                WHERE custom_field_name=?
                AND custom_field_table=?",
                $newSortOrder, $id, 'user');
        }
    }
}