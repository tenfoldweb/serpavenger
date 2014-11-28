<?php

class Api_AdminController extends Am_Controller
{
    public function checkAdminPermissions(Admin $admin)
    {
        return $admin->isSuper();
    }
    public function indexAction()
    {
        $ds = new Am_Query($this->getDi()->apiKeyTable);
        $grid = new Am_Grid_Editable('_api', ___("API Keys"), $ds, $this->_request, $this->view, $this->getDi());
        $grid->addField('comment', ___('Comment'));
        $grid->addField(new Am_Grid_Field_Expandable('key', ___('Key')))->setPlaceholder(array($this, 'truncateKey'));
        $grid->addField(new Am_Grid_Field_IsDisabled());
        
        $grid->setForm(array($this, 'createForm'));
        $grid->addCallback(Am_Grid_Editable::CB_VALUES_TO_FORM, array($this, 'valuesToForm'));
        $grid->addCallback(Am_Grid_Editable::CB_VALUES_FROM_FORM, array($this, 'valuesFromForm'));
        $grid->addCallback(Am_Grid_ReadOnly::CB_RENDER_CONTENT, array($this, 'renderContent'));
        return $grid->runWithLayout('admin/layout.phtml');        
    }

    function renderContent(& $out)
    {
        $out .= sprintf('<a href="http://www.amember.com/docs/REST" target="_blank">%s</a>', ___('REST API Documentation'));
    }

    function truncateKey($key)
    {
        return substr($key, 0, 3) . '........' . substr($key, -2, 2);
    }
    function createForm()
    {
        $form = new Am_Form_Admin;
        
        $form->addText('comment', 'size=60')->setLabel(___('Comment'))->addRule('required');
        
        $form->addText('key', 'size=60 maxlength=50')->setLabel(___('Api Key'))->addRule('required')
            ->addRule('regex', ___('Digits and latin letters only please'), '/^[a-zA-Z0-9]+$/')
            ->addRule('minlength', ___('Key must be 20 chars or longer'), 20);
        
        $form->addAdvCheckbox('is_disabled')->setLabel(___('Is Disabled'));
        
        $fs = $form->addFieldset('perms')->setLabel(___('Permissions'));;
        
        $gr = $fs->addGroup('', array('class' => 'no-label'));
        
        $module = $this->getModule();
        foreach ($module->getControllers() as $alias => $record)
        {
            $gr->addStatic()->setContent("<div style='width: 30%; font-weight: bold;'>$alias  - " . $record['comment'].'</div>');
            foreach ($record['methods'] as $method)
            {
                $gr->addCheckbox("_perms[$alias][$method]")->setContent($method);
            }
            $gr->addStatic()->setContent("<br />");
        }
        
        return $form;
    }
    
    function valuesToForm(array & $values, ApiKey $record)
    {
        if (empty($values['key']))
            $values['key'] = $this->getDi()->app->generateRandomString(20);
        
        $values['_perms'] = $record->getPerms();
    }
    
    function valuesFromForm(array & $values, ApiKey $record)
    {
        $record->setPerms($values['_perms']);
        $values['perms'] = $record->perms;
    }
    
}