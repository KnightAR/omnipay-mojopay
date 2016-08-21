<?php

namespace Omnipay\Mojopay;

use Omnipay\Common\AbstractGateway;

/**
 * Mojopay Gateway
 */
class Gateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Mojopay';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'token'          => '',
            'processorId'    => '',
            'testMode'       => false
        );
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->getParameter('token');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setToken($value)
    {
        return $this->setParameter('token', $value);
    }

    /**
     * @return $this
     */
    public function getProcessorId()
    {
        return $this->getParameter('processorId');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setProcessorId($value)
    {
        return $this->setParameter('processorId', $value);
    }

    /**
     * @param array $parameters
     * @return Message\Transaction\AuthorizeRequest
     * Authorize = auth
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Mojopay\Message\Transaction\AuthorizeRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\Transaction\PurchaseRequest
     * Purchase = sale
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Mojopay\Message\Transaction\PurchaseRequest', $parameters);
    }
    
    /**
     * @param array $parameters
     * @return Message\Transaction\CreditRequest
     * Credit = credit
     */
    public function credit(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Mojopay\Message\Transaction\CreditRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\Transaction\RefundRequest
     * Refund = refund
     */
    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Mojopay\Message\Transaction\RefundRequest', $parameters);
    }
    
    /**
     * @param array $parameters
     * @return Message\Vault\VaultCreateRequest
     * Vault Create = auth
     */
    public function createCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Mojopay\Message\Vault\VaultCreateRequest', $parameters);
    }
    
    /**
     * @param array $parameters
     * @return Message\Vault\VaultDeleteRequest
     * Vault Delete = delete
     */
    public function deleteCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Mojopay\Message\Vault\VaultDeleteRequest', $parameters);
    }
    
    /**
     * @param array $parameters
     * @return Message\Vault\VaultUpdateRequest
     * Vault Update = update
     */
    public function updateCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Mojopay\Message\Vault\VaultUpdateRequest', $parameters);
    }
    
    /**
     * @param array $parameters
     * @return Message\Vault\VaultCustomerListRecordsRequest
     * Vault List = list_customer
     */
    public function listCards(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Mojopay\Message\Vault\VaultCustomerListRecordsRequest', $parameters);
    }
    
    /**
     * @param array $parameters
     * @return Message\Transaction\CaptureRequest
     * Capture = capture
     */
    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Mojopay\Message\Transaction\CaptureRequest', $parameters);
    }
    
    /**
     * @param array $parameters
     * @return Message\Transaction\VoidRequest
     * Void = void
     */
    public function void(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Mojopay\Message\Transaction\VoidRequest', $parameters);
    }
    
    /**
     * @param array $parameters
     * @return Message\Subscription\SubscriptionAddRequest
     * Subscription Add = sub_add
     */
    public function subscription_add(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Mojopay\Message\Subscription\SubscriptionAddRequest', $parameters);
    }
    
    /**
     * @param array $parameters
     * @return Message\Subscription\SubscriptionDeleteRequest
     * Subscription Add = delete_sub
     */
    public function subscription_delete(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Mojopay\Message\Subscription\SubscriptionDeleteRequest', $parameters);
    }
}
