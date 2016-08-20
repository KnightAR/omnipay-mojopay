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
        $this->assertNull($response->getTransactionId());
    }

    public function testAuthorizeFailure()
    {
        $this->setMockHttpResponse('AuthorizeFailure.txt');
        $response = $this->gateway->authorize($this->purchaseOptions)->send();
        
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('Transaction was rejected by gateway.; Duplicate transaction REFID:3188339697', $response->getMessage());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame(300, $response->getCode());
        $this->assertNull($response->getTransactionId());
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
        $this->assertNull($response->getTransactionId());
    }

    public function testPurchaseFailure()
    {
        $this->setMockHttpResponse('AuthorizeFailure.txt');
        $response = $this->gateway->purchase($this->purchaseOptions)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('Transaction was rejected by gateway.; Duplicate transaction REFID:3188339697', $response->getMessage());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame(300, $response->getCode());
        $this->assertNull($response->getTransactionId());
    }
    
    public function testCaptureSuccess()
    {
        $this->setMockHttpResponse('CaptureSuccess.txt');
        $response = $this->gateway->capture($this->captureOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());
        $this->assertSame('3244053957', $response->getTransactionReference());
        $this->assertSame(100, $response->getCode());
        $this->assertNull($response->getTransactionId());
    }

    public function testCaptureFailure()
    {
        $this->setMockHttpResponse('CaptureFailure.txt');
        $response = $this->gateway->capture($this->captureOptions)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('Transaction was rejected by gateway.; The specified amount of 5.00 exceeds the authorization amount of 1.00 REFID:3188494937', $response->getMessage());
        $this->assertSame('3244053957', $response->getTransactionReference());
        $this->assertSame(300, $response->getCode());
        $this->assertNull($response->getTransactionId());
    }

    public function testRefundSuccess()
    {
        $this->setMockHttpResponse('RefundSuccess.txt');
        $response = $this->gateway->refund($this->captureOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());
        $this->assertSame('3246990413', $response->getTransactionReference());
        $this->assertSame(100, $response->getCode());
        $this->assertNull($response->getTransactionId());
    }

    public function testRefundFailure()
    {
        $this->setMockHttpResponse('RefundFailure.txt');
        $response = $this->gateway->refund($this->captureOptions)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('Transaction was rejected by gateway.; Invalid Transaction ID / Object ID specified:  REFID:3188495243', $response->getMessage());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame(300, $response->getCode());
        $this->assertNull($response->getTransactionId());
    }

    public function testVoidSuccess()
    {
        $this->setMockHttpResponse('VoidSuccess.txt');
        $response = $this->gateway->void($this->captureOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());
        $this->assertSame('3246978902', $response->getTransactionReference());
        $this->assertSame(100, $response->getCode());
        $this->assertNull($response->getTransactionId());
    }

    public function testVoidFailure()
    {
        $this->setMockHttpResponse('VoidFailure.txt');
        $response = $this->gateway->void($this->captureOptions)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('Transaction was rejected by gateway.; Only transactions pending settlement can be voided REFID:3188494189', $response->getMessage());
        $this->assertSame('3246978902', $response->getTransactionReference());
        $this->assertSame(300, $response->getCode());
        $this->assertNull($response->getTransactionId());
    }
}
