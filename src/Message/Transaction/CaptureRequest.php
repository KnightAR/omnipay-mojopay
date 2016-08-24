<?php

namespace Omnipay\Mojopay\Message\Transaction;

class CaptureRequest extends AuthorizeRequest
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'capture';
    }

    /**
     * @return Array
     */
    public function getData()
    {
        $this->validate('amount', 'transactionReference');

        $data = $this->getBaseData();

        $data['transactionId'] = $this->getTransactionReference();
        $data['amount'] = $this->getAmount();

        return $data;
    }
}
