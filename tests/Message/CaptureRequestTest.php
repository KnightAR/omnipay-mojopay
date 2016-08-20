<?php

namespace Omnipay\Mojopay\Test\Message;

use Omnipay\Mojopay\Message\Transaction\CaptureRequest;
use Omnipay\Tests\TestCase;

class CaptureRequestTest extends TestCase
{
    /**
     * @var CaptureRequest
     */
    protected $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = new CaptureRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array_merge($this->getBaseOptions(), array(
            'transactionId' => '3244053957',
            'amount'        => '12.00',
        )));
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('3244053957', (string)$data['transactionId']);
        $this->assertSame('12.00', (string)$data['amount']);
    }
}
