<?php

namespace Omnipay\Easyeft\Message;

use Omnipay\Tests\TestCase;

class FetchTransactionRequestTest extends TestCase
{

    protected $request;
    public function setUp()
    {
        $this->request = new FetchTransactionRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'transactionId' => 'abc123',
                'apiKey'    => 'XYZ123',
                'siteCode'  => 'Abc123'
            )
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('abc123',$data['TransactionReference']);
        $this->assertTrue(true);
    }

    public function testCompletedStatus()
    {
        $this->setMockHttpResponse('FetchTransactionComplete.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('Complete',$response->getStatus());
    }

    public function testCancelledStatus()
    {
        $this->setMockHttpResponse('FetchTransactionCancelled.txt');
        $response = $this->request->send();
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('Cancelled',$response->getStatus());
    }

    public function testPendingStatus()
    {
        $this->setMockHttpResponse('FetchTransactionPending.txt');
        $response = $this->request->send();
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('Pending',$response->getStatus());
    }
}