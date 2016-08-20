<?php

namespace Omnipay\Mojopay\Test\Message;

use Omnipay\Common\CreditCard;
use Omnipay\Mojopay\Message\Transaction\AuthorizeRequest;
use Omnipay\Tests\TestCase;

abstract BaseRequestTest extends TestCase
{
    /**
     * @var AuthorizeRequest
     */
    protected $request;

    /**
     * @return array
     */
    protected function getBaseOptions()
    {
        return array(
            'processorId'    => 'abcdefg1234567',
            'token'          => '6ef44f261a4a1595cd377d3ca7b57b92',
            'testMode'       => true,
        );
    }
    
    /**
     * @return array
     */
    protected function getOptions()
    {
        return array_merge($this->getBaseOptions(), array(
            'amount'         => '12.00',
            'currency'       => 'USD',
            'transactionId'  => '123',
            'card'           => $this->getValidCard()
        ));
    }
}
