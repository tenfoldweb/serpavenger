<?php

class Am_Plugin_SubscriptionLimit extends Am_Plugin
{
    const PLUGIN_STATUS = self::STATUS_PRODUCTION;
    const PLUGIN_REVISION = '4.4.2';

    function init()
    {
        $this->getDi()->productTable->customFields()->add(new Am_CustomFieldText('subscription_limit', ___('Subscription limit'), ___('limit amount of subscription for this product, keep empty if you do not want to limit amount of subscriptions')));
    }

    function onInvoiceBeforeInsert(Am_Event $event)
    {
        /* @var $invoice Invoice */
        $invoice = $event->getInvoice();
        foreach ($invoice->getItems() as $item)
        {
            $product = $this->getDi()->productTable->load($item->item_id);
            if (($limit = $product->data()->get('subscription_limit')) &&
                $limit < $item->qty)
            {
                throw new Am_Exception_InputError(sprintf('There is not such amount (%d) of product %s', $item->qty, $item->item_title));
            }
        }

    }

    function onInvoiceStarted(Am_Event_InvoiceStarted $event)
    {
        $invoice = $event->getInvoice();
        foreach ($invoice->getItems() as $item)
        {
            $product = $this->getDi()->productTable->load($item->item_id);

            if ($limit = $product->data()->get('subscription_limit'))
            {
                $limit -= $item->qty;
                $product->data()->set('subscription_limit', $limit);
                if (!$limit)
                {
                    $product->is_disabled = 1;
                }
                $product->save();
            }
        }
    }

    function getReadme()
    {
        return <<<CUT
This plugin allows you to limit amount of available
subscription for specific product. The product will
be disabled in case of limit reached.

You can set up limit in product settings
aMember CP -> Products -> Manage Products -> Edit (Subscription limit)
CUT;
    }
    
    function onGridProductInitGrid(Am_Event_Grid $event)
    {
        $grid = $event->getGrid();
        $grid->addField(new Am_Grid_Field('subscription_limit', ___('Limit'), false))->setRenderFunction(array($this, 'renderLimit'));
    }

    function renderLimit(Product $product)
    {
        return '<td align="center">' . ( ($limit = $product->data()->get('subscription_limit')) ? $limit : '&ndash;')  . '</td>';
    }

}