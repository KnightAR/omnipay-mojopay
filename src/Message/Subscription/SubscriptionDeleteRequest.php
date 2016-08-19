<?php

namespace Omnipay\Mojopay\Message\Subscription;

use Omnipay\Mojopay\Message\Response\SubscriptionDeleteResponse;

class SubscriptionDeleteRequest extends SubscriptionAddRequest
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'delete_sub';
    }
    
    /**
     * @return Array
     */
    public function getData()
    {
        $data = $this->getBaseData();
        if ($this->getSubscriptionId()) {
            $this->validate('subscriptionId');
            $data['subscriptionId'] = $this->getSubscriptionId();
        } else {
            $this->validate('customerHash', 'planId');
            $data['customerHash'] = $this->getCustomerHash();
            $data['planId'] = $this->getPlanId();
        }
        return $data;
    }
    
    /**
     * @param string $data
     * @return Response
     */
    protected function createResponse($data)
    {
        return $this->response = new SubscriptionDeleteResponse($this, $data);
    }
}
