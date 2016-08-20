<?php

namespace Omnipay\Mojopay\Message\Response;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Response
 */
class Response extends AbstractResponse
{
    public static $responseCodes = array(
        100 => 'Transaction was approved.',
        200 => 'Transaction was declined by processor.',
        200 => 'Transaction was declined by processor.',
        201 => 'Do not honor.',
        202 => 'Insufficient funds.',
        203 => 'Over limit.',
        204 => 'Transaction not allowed.',
        220 => 'Incorrect payment information.',
        221 => 'No such card issuer.',
        222 => 'No card number on file with issuer.',
        223 => 'Expired card.',
        224 => 'Invalid expiration date.',
        225 => 'Invalid card security code.',
        240 => 'Call issuer for further information.',
        250 => 'Pick up card.',
        251 => 'Lost card.',
        252 => 'Stolen card.',
        253 => 'Fraudulent card.',
        260 => 'Declined with further instructions available. (See responsetext)',
        261 => 'Declined­Stop all recurring payments.',
        262 => 'Declined­Stop this recurring program.',
        263 => 'Declined­Update cardholder data available.',
        264 => 'Declined­Retry in a few days.',
        300 => 'Transaction was rejected by gateway.',
        400 => 'Transaction error returned by processor.',
        410 => 'Invalid merchant configuration.',
        411 => 'Merchant account is inactive.',
        420 => 'Communication error.',
        421 => 'Communication error with issuer.',
        430 => 'Duplicate transaction at processor.',
        440 => 'Processor format error.',
        441 => 'Invalid transaction information.',
        460 => 'Processor feature not available.',
        461 => 'Unsupported card type.'
    );

    /**
     * The data contained in the response.
     *
     * @var mixed
     */
    protected $raw_data;
    
    /**
     * Constructor
     *
     * @param RequestInterface $request the initiating request.
     * @param mixed $data
     */
    public function __construct(RequestInterface $request, $raw_data)
    {
        $data = json_decode($raw_data);
        $this->raw_data = (string)$raw_data;
        parent::__construct($request, $data);
    }
    
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return isset($this->data->Response) && !is_string($this->data->Response) && isset($this->data->Response->response) && ((string)$this->data->Response->response) === '1';
    }

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return false;
    }

    /**
     * Get the transaction ID as generated by the merchant website.
     *
     * @return string
     */
    public function getTransactionId()
    {
        return isset($this->data->Response->orderid) && !empty($this->data->Response->orderid) ?
            (string)$this->data->Response->orderid : null;
    }

    /**
     * A reference provided by the gateway to represent this transaction
     *
     * @return null|string
     */
    public function getTransactionReference()
    {
        return isset($this->data->Response->transactionid) && !empty($this->data->Response->transactionid) ?
            (string)$this->data->Response->transactionid : null;
    }

    /**
     * @return null|string
     */
    public function getMessage()
    {
        $errors = array();
        if (!$this->isSuccessful() && !is_null($this->getCode()) && $this->getCode() > 100) {
            $errors[] = $this->getCodeText();
        }
        
        if (!$this->isSuccessful() && !is_null($this->getResponseText())) {
            $errors[] = $this->getResponseText();
        }

        if (isset($this->data->Response) && is_string($this->data->Response)) {
            $errors[] = (string) $this->data->Response;
        }
        
        if (empty($errors)) {
            return null;
        }

        return implode($errors, '; ');
    }
        
    /**
     * Response text
     *
     * @return null|string A response code from the payment gateway
     */
    public function getResponseText()
    {
        return ( isset($this->data->Response) && !is_string($this->data->Response) && isset($this->data->Response->responsetext) ) ? $this->data->Response->responsetext : null;
    }

    /**
     * Response code
     *
     * @return null|string A response code from the payment gateway
     */
    public function getCode()
    {
        return ( isset($this->data->Response) && !is_string($this->data->Response) && isset($this->data->Response->response_code) ) ? (int)$this->data->Response->response_code : null;
    }
    
    /**
     * Response code
     *
     * @return null|string A response code from the payment gateway
     */
    public function getCodeText()
    {
        $code = $this->getCode();
        return isset(static::$responseCodes[$code]) ? static::$responseCodes[$code] : null;
    }
    
    /**
     * Response customerHash
     *
     * @return null|string A response customerHash from the payment gateway
     */
    public function getCardReference()
    {
        return ( isset($this->data->Response) && !is_string($this->data->Response) && isset($this->data->Response->customer_hash) ) ? (int)$this->data->Response->customer_hash : null;
    }
}
