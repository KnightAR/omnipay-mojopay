<?php

namespace Omnipay\Mojopay\Message\Response;

/**
 * DeleteResponse
 */
class DeleteResponse extends Response
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return isset($this->data->Response) && is_bool($this->data->Response) && $this->data->Response === true;
    }
}
