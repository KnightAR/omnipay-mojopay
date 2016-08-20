<?php

namespace Omnipay\Mojopay\Test\Message;

use Omnipay\Common\CreditCard;
use Omnipay\Mojopay\Message\Transaction\AuthorizeRequest;
use Omnipay\Tests\TestCase;

abstract class BaseRequestTest extends TestCase
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
}
