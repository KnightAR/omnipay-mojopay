<?php

namespace Omnipay\Mojopay\Message\Transaction;

class VoidRequest extends AuthorizeRequest
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'void';
    }

    /**
     * @return Array
     */
    public function getData()
    {
        $this->validate('transactionId');

        $data = $this->getBaseData();

        $data['transactionId'] = $this->getTransactionId();

        return $data;
    }
}
