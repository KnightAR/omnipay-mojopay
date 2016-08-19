<?php

namespace Omnipay\Mojopay\Test;

use Omnipay\Mojopay\Gateway;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{

    /**
     * @var Gateway
     */
    protected $gateway;

    /**
     * @var array
     */
    protected $purchaseOptions;

    /**
     * @var array
     */
    protected $captureOptions;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->gateway->setProcessorId('abcdefg1234567');
        $this->gateway->setToken('6ef44f261a4a1595cd377d3ca7b57b92');

        $this->purchaseOptions = array(
            'amount'    => '10.00',
            'orderId'   => '123',
            'card'      => $this->getValidCard(),
        );
        $this->captureOptions  = array(
            'amount'        => '10.00',
            'transactionId' => '3244053957',
        );
    }

    public function testGatewaySettersGetters()
    {
        $this->assertSame('abcdefg1234567', $this->gateway->getProcessorId());
        $this->assertSame('6ef44f261a4a1595cd377d3ca7b57b92', $this->gateway->getToken());
    }

    public function testAuthorizeSuccess()
    {
        $this->setMockHttpResponse('AuthorizeSuccess.txt');
        $response = $this->gateway->authorize($this->purchaseOptions)->send();
        
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());
        $this->assertSame('3244053957', $response->getTransactionReference());
        $this->assertSame(100, $response->getCode());
    }

    public function testAuthorizeFailure()
    {
        $this->setMockHttpResponse('AuthorizeFailure.txt');
        $response = $this->gateway->authorize($this->purchaseOptions)->send();
        
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('Transaction was rejected by gateway.; Duplicate transaction REFID:3188339697', $response->getMessage());
        $this->assertSame(300, $response->getCode());
    }

    public function testPurchaseSuccess()
    {
        $this->setMockHttpResponse('AuthorizeSuccess.txt');
        $response = $this->gateway->purchase($this->purchaseOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());
        $this->assertSame('3244053957', $response->getTransactionReference());
        $this->assertSame(100, $response->getCode());
    }

    public function testPurchaseFailure()
    {
        $this->setMockHttpResponse('AuthorizeFailure.txt');
        $response = $this->gateway->purchase($this->purchaseOptions)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('Transaction was rejected by gateway.; Duplicate transaction REFID:3188339697', $response->getMessage());
        $this->assertSame(300, $response->getCode());
    }
}
