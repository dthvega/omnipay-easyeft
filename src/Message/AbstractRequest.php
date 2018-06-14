<?php

namespace Omnipay\Easyeft\Message;

use Omnipay\Common\Message\ResponseInterface;

/**
 * Class AbstractRequest
 * @package Omnipay\Easyeft\Message
 */
class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{

    /**
     * @var string
     */
    protected $endpoint = 'https://easyeft.co.za/';


    /**
     * @return mixed|void
     */
    public function getData()
    {
        // TODO: Implement getData() method.
    }

    /**
     * @return mixed
     */
    public function getSitecode()
    {
        return $this->getParameter('siteCode');
    }

    /**
     * @param mixed $successUrl
     */
    public function setSitecode($value)
    {
        return $this->setParameter('siteCode', $value);
    }

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * @param mixed $successUrl
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return sprintf('%s%s', $this->endpoint, $this->getMethod());
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return '';
    }

    public function sendData($data)
    {

    }
}
