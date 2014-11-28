<?php

/**
 * @package Am_View
 */
class Am_View_Helper_Obfuscate extends Zend_View_Helper_Abstract
{
    public function obfuscate($id)
    {
        return Am_Di::getInstance()->app->obfuscate($id);
    }
}

