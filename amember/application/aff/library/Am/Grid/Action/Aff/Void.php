<?php
class Am_Grid_Action_Aff_Void extends Am_Grid_Action_Abstract
{
    protected $privilege = 'void';
    protected $title;
    public function __construct($id = null, $title = null)
    {
        $this->title = ___("Void");
        $this->attributes['data-confirm'] = ___("Do you really want to void commission?");
        parent::__construct($id, $title);
    }
    public function run()
    {
        if ($this->grid->getRequest()->get('confirm'))
            return $this->void();
        else
            echo $this->renderConfirmation ();
    }
    public function void()
    {
        $record = $this->grid->getRecord();
        if(!$record->is_voided) {
            Am_Di::getInstance()->affCommissionTable->void($record);
        }
        $this->log();
        $this->grid->redirectBack();
    }
    public function isAvailable($record)
    {
        return (!$record->is_voided && ($record->record_type == AffCommission::COMMISSION));
    }

}