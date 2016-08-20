<?php

namespace Omnipay\Mojopay\Test\Message;

use Omnipay\Mojopay\Message\Transaction\VoidRequest;
use Omnipay\Tests\TestCase;

class VoidRequestTest extends TestCase
{
    /**
     * @var VoidRequest
     */
    protected $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = new VoidRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array_merge($this->getBaseOptions(), array(
            'transactionId'        => '3244053957',
        )));
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('3244053957', (string)$data['transactionId']);
    }
}
