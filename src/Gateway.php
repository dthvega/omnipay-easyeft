<?php

namespace Omnipay\Easyeft;

use Omnipay\Common\AbstractGateway;
use Omnipay\Easyeft\Message\Notification;

/**
 *
 * Easy EFT Gateway that compiles redirect fields
 *
 * Class Gateway
 * @package Omnipay\Easyeft
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Easyeft';
    }

    public function getDefaultParameters()
    {
        return array(
          'siteCode' => '',
          'testMode' => '',
          'secretKey' => ''
        );
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
     * @param array $options
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function purchase(array $options = array())
    {
        return $this->createRequest('\Omnipay\Easyeft\Message\PurchaseRequest', $options);
    }

    /**
     * @param array $options
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function fetchTransactions(array $options)
    {
        return $this->createRequest('\Omnipay\Easyeft\Message\FetchTransactionRequest', $options);
    }
}
