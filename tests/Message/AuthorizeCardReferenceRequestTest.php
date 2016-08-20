<?php

namespace Omnipay\Mojopay\Test\Message;

use Omnipay\Mojopay\Message\AuthorizeRequest;

class AuthorizeCardReferenceRequestTest extends AuthorizeRequestTest
{
    public function setUp()
    {
        parent::setUp();

        $this->request = new AuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array_merge($this->getOptions(), array(
            'card'          => null,
            'cardReference' => '1376993339'
        )));
    }

    public function testTransactionData()
    {
        $data = $this->request->getData();

        $this->assertNull($this->request->getCard());
        
        $this->assertSame('auth', (string)$data['type']);
        
        $this->assertSame('123', (string)$data['orderId']);
        $this->assertSame('12.00', (string)$data['amount']);
        $this->assertSame('1376993339', (string)$data['customerHash']);
        $this->assertSame('USD', (string)$data['currency']);
    }

    public function testGetDataCustomerDetails()
    {
        //
    }
}
