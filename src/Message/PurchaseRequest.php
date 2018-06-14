<?php

namespace Omnipay\Easyeft\Message;


class PurchaseRequest extends AbstractRequest
{
    private $countryCode;
    private $bankReference;
    private $optional;
    private $customerName;
    private $cancelUrl;
    private $errorUrl;
    private $successUrl;
    private $notifyUrl;

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->getParameter('countryCode');
    }

    /**
     * The ISO 3166-1 alpha-2 code for the user's
     * country. The country code will determine which
     * banks will be displayed to the customer. Please
     * note only South African (ZA) banks are currently
     * supported by EasyEFT.
     *
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setCountryCode($value)
    {
        return $this->setParameter('countryCode', $value);
    }

    /**
     * @return mixed
     */
    public function getBankReference()
    {
        return $this->getParameter('bankReference');
    }

    /**
     * The reference that will be prepopulated in the
     * "their reference" field in the customers online
     * banking site. This will be the payment reference
     * that appears on your transaction history.
     *
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setBankReference($value)
    {
        return $this->setParameter('bankReference', $value);
    }

    /**
     * @return mixed
     */
    public function getOptional()
    {
        return $this->getParameter('optional');
    }

    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setOptional($value)
    {
        return $this->setParameter('optional', $value);
    }


    /**
     * @return mixed
     */
    public function getCustomerName()
    {
        return $this->getParameter('customerName');
    }

    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setCustomerName($value)
    {
        return $this->setParameter('customerName', $value);
    }


    /**
     * @return mixed|string
     */
    public function getCancelUrl()
    {
        return $this->getParameter('cancelUrl');
    }


    /**
     * @param string $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setCancelUrl($value)
    {
        return $this->setParameter('cancelUrl', $value);
    }


    /**
     * @return mixed
     */
    public function getErrorUrl()
    {
        return $this->getParameter('errorUrl');
    }


    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setErrorUrl($value)
    {
        return $this->setParameter('errorUrl', $value);
    }


    /**
     * @return mixed
     */
    public function getSuccessUrl()
    {
        return $this->getParameter('successUrl');
    }


    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setSuccessUrl($value)
    {
        return $this->setParameter('successUrl', $value);
    }

    /**
     * @return mixed|string
     */
    public function getNotifyUrl()
    {
        return $this->getParameter('notifyUrl');
    }

    /**
     * @param string $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setNotifyUrl($value)
    {
        return $this->setParameter('notifyUrl', $value);
    }

    public function getData()
    {

        $this->validate(
            'siteCode',
            'countryCode',
            'currency',
            'amount',
            'transactionId',
            'bankReference'
        );
        $data = $this->getPostData();
        $data['HashCheck'] = $this->generateHash($data);
        return $data;
    }

    protected function generateHash($data)
    {
        $toHash =  strtolower(sprintf('%s%s', implode("", $data), $this->getSecretKey()));
        return hash('sha512', $toHash);
    }

    public function getMethod()
    {
        return 'payment';
    }


    /**
     * @return mixed|void
     */
    public function getPostData()
    {
        $data = array(
          'SiteCode'           => $this->getSitecode(),
          'CountryCode'         => $this->getCountryCode(),
          'CurrencyCode'        => $this->getCurrency(),
          'Amount'              => $this->getAmount(),
          'TransactionReference'=> $this->getTransactionId(),
          'BankReference'       => $this->getBankReference(),
        );
        //remove associative array
        $options = array_values($this->getOptional());
        for ($i = 0; $i < 5; $i++) {
            if (array_key_exists($i, $options)) {
                $data['Optional' . ($i+1)] = $options[$i];
            }
        }
        $data2 = array(
          'Customer'          => $this->getCustomerName(),
          'CancelUrl'           => $this->getCancelUrl(),
          'ErrorUrl'            => $this->getErrorUrl(),
          'SuccessUrl'          => $this->getSuccessUrl(),
          'NotifyUrl'           => $this->getNotifyUrl(),
          'IsTest'              => ($this->getTestMode()) ? "true" : "false"
        );


        //remove empty elements
        return array_filter($data + $data2);
    }

    public function sendData($data)
    {
        return new Response($this, $data);
    }
}
