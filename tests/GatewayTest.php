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
        $this->gateway->setTestMode(true);        

        $this->purchaseOptions = array(
            'amount'    => '10.00',
            'orderId'   => '123',
            'card'      => $this->getValidCard(),
        );
        $this->captureOptions  = array(
            'amount'        => '10.00',
            'transactionId' => '3244053957',
        );
        $this->cardCreateReferenceOptions = array(
             'card' => $this->getValidCard()
        );
        $this->cardUpdateReferenceOptions = array(
             'cardReference' => '1376993339',
             'card'          => $this->getValidCard()
        );
        $this->cardDeleteReferenceOptions = array(
             'cardReference' => '1376993339'
        );
    }

    public function testGatewaySettersGetters()
    {
        $this->assertSame('abcdefg1234567', $this->gateway->getProcessorId());
        $this->assertSame('6ef44f261a4a1595cd377d3ca7b57b92', $this->gateway->getToken());
        $this->assertSame(true, $this->gateway->getTestMode());
    }

    public function testAuthorizeSuccess()
    {
        $this->setMockHttpResponse('AuthorizeSuccess.txt');
        $response = $this->gateway->authorize($this->purchaseOptions)->send();
        
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());
        $this->assertSame('Transaction was approved.', $response->getCodeText());
        $this->assertSame('SUCCESS', $response->getResponseText());
        $this->assertSame('3244053957', $response->getTransactionReference());
        $this->assertSame(100, $response->getCode());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getCardReference());
    }

    public function testAuthorizeFailure()
    {
        $this->setMockHttpResponse('AuthorizeFailure.txt');
        $response = $this->gateway->authorize($this->purchaseOptions)->send();
        
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('Transaction was rejected by gateway.; Duplicate transaction REFID:3188339697', $response->getMessage());
        $this->assertSame('Duplicate transaction REFID:3188339697', $response->getResponseText());
        $this->assertSame('Transaction was rejected by gateway.', $response->getCodeText());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame(300, $response->getCode());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getCardReference());
    }

    public function testPurchaseSuccess()
    {
        $this->setMockHttpResponse('AuthorizeSuccess.txt');
        $response = $this->gateway->purchase($this->purchaseOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());
        $this->assertSame('Transaction was approved.', $response->getCodeText());
        $this->assertSame('SUCCESS', $response->getResponseText());
        $this->assertSame('3244053957', $response->getTransactionReference());
        $this->assertSame(100, $response->getCode());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getCardReference());
    }

    public function testPurchaseFailure()
    {
        $this->setMockHttpResponse('AuthorizeFailure.txt');
        $response = $this->gateway->purchase($this->purchaseOptions)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('Transaction was rejected by gateway.; Duplicate transaction REFID:3188339697', $response->getMessage());
        $this->assertSame('Duplicate transaction REFID:3188339697', $response->getResponseText());
        $this->assertSame('Transaction was rejected by gateway.', $response->getCodeText());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame(300, $response->getCode());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getCardReference());
    }
    
    public function testCaptureSuccess()
    {
        $this->setMockHttpResponse('CaptureSuccess.txt');
        $response = $this->gateway->capture($this->captureOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());
        $this->assertSame('Transaction was approved.', $response->getCodeText());
        $this->assertSame('SUCCESS', $response->getResponseText());
        $this->assertSame('3244053957', $response->getTransactionReference());
        $this->assertSame(100, $response->getCode());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getCardReference());
    }

    public function testCaptureFailure()
    {
        $this->setMockHttpResponse('CaptureFailure.txt');
        $response = $this->gateway->capture($this->captureOptions)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('Transaction was rejected by gateway.; The specified amount of 5.00 exceeds the authorization amount of 1.00 REFID:3188494937', $response->getMessage());
        $this->assertSame('The specified amount of 5.00 exceeds the authorization amount of 1.00 REFID:3188494937', $response->getResponseText());
        $this->assertSame('Transaction was rejected by gateway.', $response->getCodeText());
        $this->assertSame('3244053957', $response->getTransactionReference());
        $this->assertSame(300, $response->getCode());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getCardReference());
    }

    public function testRefundSuccess()
    {
        $this->setMockHttpResponse('RefundSuccess.txt');
        $response = $this->gateway->refund($this->captureOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());
        $this->assertSame('Transaction was approved.', $response->getCodeText());
        $this->assertSame('SUCCESS', $response->getResponseText());
        $this->assertSame('3246990413', $response->getTransactionReference());
        $this->assertSame(100, $response->getCode());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getCardReference());
    }

    public function testRefundFailure()
    {
        $this->setMockHttpResponse('RefundFailure.txt');
        $response = $this->gateway->refund($this->captureOptions)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('Transaction was rejected by gateway.; Invalid Transaction ID / Object ID specified:  REFID:3188495243', $response->getMessage());
        $this->assertSame('Invalid Transaction ID / Object ID specified:  REFID:3188495243', $response->getResponseText());
        $this->assertSame('Transaction was rejected by gateway.', $response->getCodeText());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame(300, $response->getCode());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getCardReference());
    }

    public function testVoidSuccess()
    {
        $this->setMockHttpResponse('VoidSuccess.txt');
        $response = $this->gateway->void($this->captureOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());
        $this->assertSame('Transaction was approved.', $response->getCodeText());
        $this->assertSame('Transaction Void Successful', $response->getResponseText());
        $this->assertSame('3246978902', $response->getTransactionReference());
        $this->assertSame(100, $response->getCode());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getCardReference());
    }

    public function testVoidFailure()
    {
        $this->setMockHttpResponse('VoidFailure.txt');
        $response = $this->gateway->void($this->captureOptions)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('Transaction was rejected by gateway.; Only transactions pending settlement can be voided REFID:3188494189', $response->getMessage());
        $this->assertSame('Only transactions pending settlement can be voided REFID:3188494189', $response->getResponseText());
        $this->assertSame('Transaction was rejected by gateway.', $response->getCodeText());
        $this->assertSame('3246978902', $response->getTransactionReference());
        $this->assertSame(300, $response->getCode());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getCardReference());
    }
    
    public function testCardCreateSuccess()
    {
        $this->setMockHttpResponse('CardCreateSuccess.txt');
        $response = $this->gateway->createCard($this->cardCreateReferenceOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());
        $this->assertSame('Transaction was approved.', $response->getCodeText());
        $this->assertSame('SUCCESS', $response->getResponseText());
        $this->assertSame('3247070784', $response->getTransactionReference());
        $this->assertSame(100, $response->getCode());
        $this->assertNull($response->getTransactionId());
        $this->assertSame('1376993339', $response->getCardReference());
    }
    
    public function testCardDeleteSuccess()
    {
        $this->setMockHttpResponse('CardDeleteSuccess.txt');
        $response = $this->gateway->deleteCard($this->cardDeleteReferenceOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());
        $this->assertNull($response->getCodeText());
        $this->assertNull($response->getResponseText());
        $this->assertNull($response->getTransactionReference());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getCardReference());
        
        $responseData = $response->getData();
        $this->assertSame(true, $responseData->Response);
    }    
    
    public function testCardUpdateFailure()
    {
        $this->setMockHttpResponse('CardUpdateFailure.txt');
        $response = $this->gateway->updateCard($this->cardUpdateReferenceOptions)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame("Customer Hash missing", $response->getMessage());
        $this->assertNull($response->getCodeText());
        $this->assertNull($response->getResponseText());
        $this->assertNull($response->getTransactionReference());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getCardReference());
        
        $responseData = $response->getData();
        $this->assertSame("Customer Hash missing", $response->Response);
    }
    
    public function testCardUpdateSuccess()
    {
        $this->setMockHttpResponse('CardUpdateSuccess.txt');
        $response = $this->gateway->updateCard($this->cardUpdateReferenceOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());
        $this->assertSame('Transaction was approved.', $response->getCodeText());
        $this->assertSame('Customer Update Successful', $response->getResponseText());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame(100, $response->getCode());
        $this->assertNull($response->getTransactionId());
        $this->assertSame('1376993339', $response->getCardReference());
    }
}
