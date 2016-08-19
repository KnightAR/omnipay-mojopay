<?php

namespace Omnipay\Mojopay\Message\Transaction;

class PurchaseRequest extends AuthorizeRequest
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'sale';
    }
}
