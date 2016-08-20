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
        $this->validate('amount');

        $data = $this->getBaseData();

        $data['transactionId'] = $this->getTransactionId();
        $data['amount'] = $this->getAmount();

        return $data;
    }
}
