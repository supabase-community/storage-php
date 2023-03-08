<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class VCRStorageBucketTest extends TestCase
{
	private $client;

	public function setup(): void
	{
		parent::setUp();
		$dotenv = \Dotenv\Dotenv::createUnsafeImmutable(__DIR__, '/../../.env.test');
		$dotenv->load();
		$api_key = getenv('API_KEY');
		$reference_id = getenv('REFERENCE_ID');
		$this->client = new  \Supabase\Storage\StorageClient($api_key, $reference_id);
	}

	/**
	 * Test Retrieves the details of all Storage buckets within an existing project function.
	 *
	 * @return void
	 */
	public function testListBucket()
	{
		// After turning on the VCR will intercept all requests
		\VCR\VCR::turnOn();

		// Record requests and responses in cassette file 'example'
		\VCR\VCR::insertCassette('unit_storage_bucket_test');

		// Following request will be recorded once and replayed in future test runs
		$result = $this->client->listBuckets();
		$this->assertNotEmpty($result);

		// To stop recording requests, eject the cassette
		\VCR\VCR::eject();

		// Turn off VCR to stop intercepting requests
		\VCR\VCR::turnOff();
	}

	/**
	 * Test Creates a new Storage bucket function.
	 *
	 * @return void
	 */
	public function testCreateBucket(): void
	{
		\VCR\VCR::turnOn();
		\VCR\VCR::insertCassette('unit_storage_bucket_test');
		$result = $this->client->createBucket('vcr-bucket', ['public' => true]);
		$this->assertNotEmpty($result);
		\VCR\VCR::eject();
		\VCR\VCR::turnOff();
	}

	/**
	 * Test Retrieves the details of an existing Storage bucket function.
	 *
	 * @return void
	 */
	public function testGetBucketWithId(): void
	{
		\VCR\VCR::turnOn();
		\VCR\VCR::insertCassette('unit_storage_bucket_test');
		$result = $this->client->getBucket('vcr-bucket');
		$this->assertNotEmpty($result);
		\VCR\VCR::eject();
		\VCR\VCR::turnOff();
	}

	/**
	 * Test Updates a Storage bucket function.
	 *
	 * @return void
	 */
	public function testUpdateBucket(): void
	{
		\VCR\VCR::turnOn();
		\VCR\VCR::insertCassette('unit_storage_bucket_test');
		$result = $this->client->updateBucket('vcr-bucket', ['public' => false]);
		$this->assertNotEmpty($result);
		\VCR\VCR::eject();
		\VCR\VCR::turnOff();
	}

	public function testUpdateWrongBucket(): void
	{
		try {
			$result = $this->client->getBucket('not-a-real-bucket-id');

			\VCR\VCR::turnOn();
			\VCR\VCR::insertCassette('unit_storage_bucket_test');
			$result = $this->client->updateBucket('my-new-storage-bucket-vcr-not-existed', ['public' => true]);
			$this->assertNotEmpty($result);
			\VCR\VCR::eject();
			\VCR\VCR::turnOff();
		} catch (\Exception $e) {
			$this->assertEquals('The resource was not found', $e->getMessage());
		}
	}

	/**
	 * Test Removes all objects inside a single bucket function.
	 *
	 * @return void
	 */
	public function testEmptyBucket(): void
	{
		\VCR\VCR::turnOn();
		\VCR\VCR::insertCassette('unit_storage_bucket_test');
		$result = $this->client->emptyBucket('bucket-private');
		$this->assertNotEmpty($result);
		\VCR\VCR::eject();
		\VCR\VCR::turnOff();
	}

	/**
	 * Test Deletes an existing bucket function.
	 *
	 * @return void
	 */
	public function testDeleteBucket(): void
	{
		\VCR\VCR::turnOn();
		\VCR\VCR::insertCassette('unit_storage_bucket_test');
		$result = $this->client->deleteBucket('vcr-bucket');
		$this->assertNotEmpty($result);
		\VCR\VCR::eject();
		\VCR\VCR::turnOff();
	}

	/**
	 * Test Invailid bucket id function.
	 *
	 * @return void
	 */
	public function testGetBucketWithInvalidId(): void
	{
		try {
			\VCR\VCR::turnOn();
			\VCR\VCR::insertCassette('unit_storage_bucket_test');
			$result = $this->client->getBucket('not-a-real-bucket-id');
			$this->assertNotEmpty($result);
			\VCR\VCR::eject();
			\VCR\VCR::turnOff();
		} catch (\Exception $e) {
			$this->assertEquals('The resource was not found', $e->getMessage());
		}
	}

	/**
	 * Test Creates a new Storage public bucket function.
	 *
	 * @return void
	 */
	public function testCreatePublicBucket(): void
	{
		\VCR\VCR::turnOn();
		\VCR\VCR::insertCassette('unit_storage_bucket_test');
		$result = $this->client->createBucket('bucket-public', ['public' => true]);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$this->assertJsonStringEqualsJsonString('{"name":"bucket-public"}', (string) $result->getBody());
		$resultInfo = $this->client->getBucket('bucket-public');
		$getValue = json_decode((string)$resultInfo->getBody());
		$isPrivate = $getValue->{'public'};
		$this->assertTrue($isPrivate);
		$this->assertNotEmpty($result);
		\VCR\VCR::eject();
		\VCR\VCR::turnOff();
	}
}
