<?php

namespace Omnipay\Easyeft\Message;


use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\ResponseInterface;

class FetchTransactionResponse extends AbstractResponse implements ResponseInterface
{
    public function getData()
    {
        return $this->data;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function isSuccessful()
    {
        return ($this->getStatus() == 'Complete');
    }

    public function isRedirect()
    {
        false;
    }

    public function isCancelled()
    {
        return ($this->getStatus() == 'Cancelled');
    }

    public function getMessage()
    {
        return (key_exists('StatusMessage', $this->data))? $this->data['StatusMessage'] : '';
    }

    public function getTransactionReference()
    {
        return (key_exists('TransactionId', $this->data))? $this->data['TransactionId'] : '';
    }

    public function isPending()
    {
        return ($this->getStatus() == 'Pending' || $this->getStatus() == 'PendingInvestigation');
    }

    public function getStatus()
    {
        return (key_exists('Status', $this->data))? $this->data['Status'] : 'Failed';
    }
}
