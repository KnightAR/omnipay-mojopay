<?php

namespace Omnipay\Mojopay\Message\Vault;

class VaultCreateRequest extends VaultAuthorizeRequest
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'create';
    }
    
    /**
     * @return Array
     * @throws InvalidCreditCardException
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $data = $this->getBaseData();

        $this->setCardCredentials($data);
        $this->setShippingCredentials($data);
        $this->setCardHolderCredentials($data);
        
        return $data;
    }
}
