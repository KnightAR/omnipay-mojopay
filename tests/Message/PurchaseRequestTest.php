<?php

namespace Omnipay\Mojopay\Test\Message;

use Omnipay\Mojopay\Message\Transaction\PurchaseRequest;

class PurchaseRequestTest extends AuthorizeRequestTest
{
    public function setUp()
    {
        parent::setUp();

        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getOptions());
    }
}
