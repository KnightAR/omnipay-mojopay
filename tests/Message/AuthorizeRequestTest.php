<?php

namespace Omnipay\Mojopay\Test\Message;

use Omnipay\Common\CreditCard;
use Omnipay\Mojopay\Message\Transaction\AuthorizeRequest;
use Omnipay\Tests\TestCase;

class AuthorizeRequestTest extends TestCase
{
    /**
     * @var AuthorizeRequest
     */
    protected $request;

    /**
     * @return array
     */
    protected function getOptions()
    {
        return array(
            'processorId'    => 'abcdefg1234567',
            'token'          => '6ef44f261a4a1595cd377d3ca7b57b92',
            'testMode'       => true,
            'amount'         => '12.00',
            'currency'       => 'USD',
            'transactionId'  => '123',
            'card'           => $this->getValidCard()
        );
    }

    public function setUp()
    {
        parent::setUp();

        $this->request = new AuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getOptions());
    }

    public function testBaseData()
    {
        $data = $this->request->getData();

        $this->assertSame('auth', (string)$data['type']);
        $this->assertSame('6ef44f261a4a1595cd377d3ca7b57b92', (string)$data['token']);
        $this->assertSame('abcdefg1234567', (string)$data['processorId']);
    }

    public function testTransactionData()
    {
        /** @var CreditCard $card */
        $card = $this->request->getCard();
        $data = $this->request->getData();

        $this->assertSame('123', (string)$data['orderId']);
        $this->assertSame('12.00', (string)$data['amount']);
        $this->assertSame('1376993339', (string)$data['customerHash']);
        $this->assertSame('USD', (string)$data['currency']);

        $this->assertSame($card->getNumber(), (string)$data['number']);
        $this->assertSame($card->getExpiryDate('ym'), $date['expirationDate']);
        $this->assertSame((string)$card->getCvv(), (string)$data['cardSecurityCode']);
    }

    public function testGetDataCustomerDetails()
    {
        /** @var CreditCard $card */
        $card = $this->request->getCard();
        $data = $this->request->getData();
        
        $this->assertSame((string)$card->getShippingFirstName(), (string)$data['firstNameShipping']);
        $this->assertSame((string)$card->getShippingLastName(), (string)$data['lastNameShipping']);
        $this->assertSame((string)$card->getShippingCompany(), (string)$data['companyShipping']);
        $this->assertSame((string)$card->getShippingCountry(), (string)$data['countryShipping']);
        $this->assertSame((string)$card->getShippingAddress1(), (string)$data['addressShipping']);
        $this->assertSame((string)$card->getShippingAddress2(), (string)$data['addressContShipping']);
        $this->assertSame((string)$card->getShippingCity(), (string)$data['cityShipping']);
        $this->assertSame((string)$card->getShippingState(), (string)$data['stateProvinceShipping']);
        $this->assertSame((string)$card->getShippingPostcode(), (string)$data['zipPostalCodeShipping']);
        $this->assertSame((string)$card->getShippingPhone(), (string)$data['phoneNumberShipping']);
        $this->assertSame((string)$card->getShippingFax(), (string)$data['faxNumberShipping']);
        $this->assertSame((string)$card->getEmail(), (string)$data['emailAddressShipping']);
        
        $this->assertSame((string)$card->getFirstName(), (string)$data['firstNameCard']);
        $this->assertSame((string)$card->getLastName(), (string)$data['lastNameCard']);
        $this->assertSame((string)$card->getCompany(), (string)$data['companyCard']);
        $this->assertSame((string)$card->getCountry(), (string)$data['countryCard']);
        $this->assertSame((string)$card->getAddress1(), (string)$data['addressCard']);
        $this->assertSame((string)$card->getAddress2(), (string)$data['addressContCard']);
        $this->assertSame((string)$card->getCity(), (string)$data['cityCard']);
        $this->assertSame((string)$card->getState(), (string)$data['stateProvinceCard']);
        $this->assertSame((string)$card->getPostcode(), (string)$data['zipPostalCodeCard']);
        $this->assertSame((string)$card->getPhone(), (string)$data['phoneNumberCard']);
        $this->assertSame((string)$card->getBillingFax(), (string)$data['faxNumberCard']);
        $this->assertSame((string)$card->getEmail(), (string)$data['emailAddressCard']);
    }
}
