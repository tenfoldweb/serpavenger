<?php

/**
 * View helper to display admin tabs 
 * @package Am_View
 */
class Am_View_Helper_AdminTabs extends Zend_View_Helper_Abstract
{
    function adminTabs(Zend_Navigation $menu)
    {
        $m = new Am_View_Helper_Menu();
        $m->setView($this->view);
        //$m->setAcl($this->view->di->authAdmin->getUser());
        $out = <<<CUT
<script type="text/javascript">
jQuery(document).ready(function($) {
    $('.am-tabs li:has(ul) > a').prepend(
        $('<span></span>').addClass('arrow')
    );
    $('.am-tabs .has-children > ul').bind('mouseenter mouseleave', function(){
        $(this).closest('li').toggleClass('active expanded');
    });
            
});
</script>
CUT;
        $out .= '<div class="am-tabs-wrapper">';
        $out .= $m->renderMenu($menu,
            array(
                'ulClass' => 'am-tabs',
                'activeClass' => 'active',
                'normalClass' => 'normal',
                'disabledClass' => 'disabled',
                'maxDepth' => 1,
            )
        );
        $out .= '</div>';
        return $out;
    }
}