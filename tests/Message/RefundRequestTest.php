<?php

namespace Omnipay\Mojopay\Test\Message;

use Omnipay\Mojopay\Message\RefundRequest;
use Omnipay\Tests\TestCase;

class RefundRequestTest extends TestCase
{
    /**
     * @var RefundRequest
     */
    protected $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'amount'        => '12.00',
            'transactionId' => '3244053957',
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('transactionId', (string)$data['transactionId']);
        $this->assertSame('12.00', (string)$data['amount']);
    }
}
