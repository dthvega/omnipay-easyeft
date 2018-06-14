<?php

namespace Omnipay\Easyeft;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{

    protected $gateway;

    public function setUp()
    {
        parent::setUp();
        $this->gateway = new Gateway($this->getHttpClient(),$this->getHttpRequest());
        $this->gateway->setSitecode('abc123');
        $this->gateway->setSecretKey('XYZ321');
    }

    public function testRedirectPurchase()
    {
        $id = 'XCX123';
        $response = $this->gateway->purchase(
            array(
                'countryCode' => 'ZA',
                'currency'  => 'ZAR',
                'amount' => '50.00',
                'transactionId' => uniqid(),
                'optional' => array(
                    'One','two','three','four','five'
                ),
                'customerName' => 'Rickus',
                'bankReference' => 'ABC 123',
                'cancelUrl' => 'test-url.com/cancel',
                'errorUrl' => 'test-url.com/error',
                'successUrl' => 'test-url.com/success',
                'notifyUrl' => 'test-url.com/notify',
            )
        )->send();

        $this->assertTrue($response->isRedirect());
        $this->assertContains('50.00',$response->getRedirectData());
        $this->assertContains('Rickus',$response->getRedirectData());
        $this->assertContains('ABC 123',$response->getRedirectData());
    }

}