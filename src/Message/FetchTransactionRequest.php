<?php

namespace Omnipay\Easyeft\Message;


class FetchTransactionRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('siteCode', 'transactionId', 'apiKey');
        $data = array(
            'siteCode' => $this->getSitecode(),
            'TransactionReference' => $this->getTransactionId(),
            'isTest' => ($this->getTestMode()) ? 'true' : 'false'
        );

        return $data;
    }

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    public function getMethod()
    {
        return 'api/MerchantApiV1/GetTransactionByReference';
    }

    public function sendData($data)
    {

        $httpResponse = $this->httpClient->request(
            'GET',
            sprintf('%s?%s', $this->getEndpoint(), http_build_query($data)),
            ['Accept' => 'application/json', 'apiKey' => $this->getApiKey()]
        );
        try {
            $data = json_decode($httpResponse->getBody()->getContents(),true)[0];
        } catch (\Exception $e) {
            $data = [];
        }

         return new FetchTransactionResponse($this, $data);
    }
}
