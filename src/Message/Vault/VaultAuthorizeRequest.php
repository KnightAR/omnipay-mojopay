<?php

namespace Omnipay\Mojopay\Message\Vault;

use Omnipay\Mojopay\Message\Transaction\AuthorizeRequest;

class VaultAuthorizeRequest extends AuthorizeRequest
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'auth';
    }
    
    /**
     * @return Array
     * @throws InvalidCreditCardException
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('amount', 'customerHash');

        $data = $this->getBaseData();

        $data['customerHash'] = $this->getCustomerHash();
        $data['amount'] = $this->getAmount();
        $data['orderId'] = $this->getTransactionId();
        $data['orderDescription'] = $this->getDescription();
          
        return $data;
    }
    
    /**
     * @return string
     */
    public function getCustomerHash()
    {
        return $this->getParameter('customerHash');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setCustomerHash($value)
    {
        return $this->setParameter('customerHash', $value);
    }
    
}
