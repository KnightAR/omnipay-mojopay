<?php

namespace Omnipay\Mojopay\Message\Vault;

use Omnipay\Mojopay\Message\Transaction\AuthorizeRequest;
use Omnipay\Mojopay\Message\Response\DeleteResponse;

class VaultDeleteRequest extends AuthorizeRequest
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'delete';
    }
    
    /**
     * @return Array
     */
    public function getData()
    {
        $this->validate('cardReference');
        $data = $this->getBaseData();
        $data['customerHash'] = $this->getCardReference();
        return $data;
    }
    
    /**
     * @param string $data
     * @return Response
     */
    protected function createResponse($data)
    {
        return $this->response = new DeleteResponse($this, $data);
    }
}
