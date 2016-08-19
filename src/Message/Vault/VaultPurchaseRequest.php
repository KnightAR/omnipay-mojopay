<?php

namespace Omnipay\Mojopay\Message\Vault;

class VaultPurchaseRequest extends VaultAuthorizeRequest
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'sale';
    }
}