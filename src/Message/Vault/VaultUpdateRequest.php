<?php

namespace Omnipay\Mojopay\Message\Vault;

class VaultUpdateRequest extends VaultCreateRequest
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'update';
    }
}
