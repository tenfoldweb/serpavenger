<?php

class Am_Plugin_ThanksRedirect extends Am_Plugin
{
    function onGridProductInitForm(Am_Event_Grid $event)
    {
        $event->getGrid()->getForm()->getAdditionalFieldSet()->addText('_thanks_redirect_url', array('class' => 'el-wide'))
            ->setLabel(___("After Purchase Redirect User to this URL\ninstead of thanks page\n" .
                'You can use %invoice.% and %user.% variables in url eg: %user.login%, %user.email%, %invoice.public_id% etc.'));
        
    }
    function onGridProductValuesFromForm(Am_Event_Grid $event)
    {
        $args = $event->getArgs();
        $product = $args[1];
        $product->data()->set('thanks_redirect_url', @$args[0]['_thanks_redirect_url']);
    }
    function onGridProductValuesToForm(Am_Event_Grid $event)
    {
        $args = $event->getArgs();
        $product = $args[1];
        $args[0]['_thanks_redirect_url'] = $product->data()->get('thanks_redirect_url');
    }
    function onThanksPage(Am_Event $event)
    {
        if(!$event->getInvoice()) return;
        $url = null;
        foreach ($event->getInvoice()->getProducts() as $pr)
            if ($url = $pr->data()->get('thanks_redirect_url'))
                break;
        $t = new Am_SimpleTemplate();
        $t->assign('invoice', $event->getInvoice());
        $t->assign('user', $event->getInvoice()->getUser());
        $url = $t->render($url);
        if ($url)
            $event->getController()->redirectLocation($url);
    }
}
