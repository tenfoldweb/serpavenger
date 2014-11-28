<?php

class Api_AccessController extends Am_Controller_Api_Table
{
    public function createTable()
    {
        return $this->getDi()->accessTable;
    }
}
