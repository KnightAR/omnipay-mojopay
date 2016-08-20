<?php

namespace Omnipay\Mojopay\Message\Vault;

use Omnipay\Mojopay\Message\Transaction\AuthorizeRequest;

class VaultCreateRequest extends AuthorizeRequest
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
