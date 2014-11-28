<?php

class Api_BillingPlansController extends Am_Controller_Api_Table
{
    public function createTable()
    {
        return $this->getDi()->billingPlanTable;
    }
}
