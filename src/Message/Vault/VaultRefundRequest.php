<?php

namespace Omnipay\Mojopay\Message\Vault;

class VaultRefundRequest extends VaultAuthorizeRequest
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'credit';
    }
}