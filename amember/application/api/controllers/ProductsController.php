<?php

class Api_ProductsController extends Am_Controller_Api_Table
{
    protected $_nested = array(
        'billing-plans' => array('class' => 'Api_BillingPlansController', 'file' => 'api/controllers/BillingPlansController.php'),
    );
    protected $_defaultNested = array('billing-plans');
    
    public function createTable()
    {
        return $this->getDi()->productTable;
    }
}