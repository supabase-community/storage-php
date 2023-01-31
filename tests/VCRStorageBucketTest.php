<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class VCRStorageBucketTest extends TestCase
{

    private $client;

    /**
     * 
     */

    public function setup(): void {
        parent::setUp();
        $authHeader = ['Authorization' => 'Bearer ' . $_ENV['SERVICE_ROLE']];
        $this->client = new  \Supabase\Storage\StorageClient('https://'.$_ENV['PROJECT_REF'].'.supabase.co/storage/v1', $authHeader);
    }

    public function testListBucket()
    {
        // After turning on the VCR will intercept all requests
        \VCR\VCR::turnOn();

        // Record requests and responses in cassette file 'example'
        \VCR\VCR::insertCassette('storageBucketTest');

        // Following request will be recorded once and replayed in future test runs
        $result = $this->client->listBuckets();
        $this->assertNotEmpty($result);

        // To stop recording requests, eject the cassette
        \VCR\VCR::eject();

        // Turn off VCR to stop intercepting requests
        \VCR\VCR::turnOff();
    }

    public function testShouldThrowExceptionIfNoCasettePresent()
    {
        $this->setExpectedException(
            'BadMethodCallException',
            "Invalid http request. No cassette inserted. Please make sure to insert "
            . "a cassette in your unit test using VCR::insertCassette('name');"
        );
        \VCR\VCR::turnOn();
        // If there is no cassette inserted, a request throws an exception
        file_get_contents('http://example.com');
    }
}