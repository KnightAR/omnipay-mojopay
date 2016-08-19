<?php

namespace Omnipay\Mojopay\Message\Vault;

class VaultUpdateRequest extends VaultAuthorizeRequest
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'update';
    }
}
