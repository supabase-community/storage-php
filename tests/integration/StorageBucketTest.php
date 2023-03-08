<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class StorageBucketTest extends TestCase
{
	private $client;

	public function setup(): void
	{
		parent::setUp();
		$dotenv = \Dotenv\Dotenv::createUnsafeImmutable(__DIR__, '/../../.env.test');
		$dotenv->load();
		$api_key = getenv('API_KEY');
		$reference_id = getenv('REFERENCE_ID');
		$this->client = new  \Supabase\Storage\StorageBucket($api_key, $reference_id);
	}

	/**
	 * Test Retrieves the details of all Storage buckets within an existing project function.
	 *
	 * @return void
	 */
	public function testListBucket(): void
	{
		$result = $this->client->listBuckets();
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
	}

	/**
	 * Test Creates a new Storage bucket function.
	 *
	 * @return void
	 */
	public function testCreateBucket(): void
	{
		$result = $this->client->createBucket('test-bucket-new', ['public' => true]);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$getValue = json_decode((string) $result->getBody());
		$obj = $getValue->{'name'};
		$this->assertEquals('test-bucket-new', $obj);
	}

	/**
	 * Test Retrieves the details of an existing Storage bucket function.
	 *
	 * @return void
	 */
	public function testGetBucketWithId(): void
	{
		$result = $this->client->getBucket('test-bucket');
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$getValue = json_decode((string) $result->getBody());
		$obj = $getValue->{'id'};
		$this->assertEquals('test-bucket', $obj);
	}

	/**
	 * Test Updates a Storage bucket function.
	 *
	 * @return void
	 */
	public function testUpdateBucket(): void
	{
		$result = $this->client->updateBucket('test-bucket-new', ['public' => true]);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$this->assertJsonStringEqualsJsonString('{"message":"Successfully updated"}', (string) $result->getBody());
	}

	/**
	 * Test Removes all objects inside a single bucket function.
	 *
	 * @return void
	 */
	public function testEmptyBucket()
	{
		$result = $this->client->emptyBucket('test-bucket-new');
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$this->assertJsonStringEqualsJsonString('{"message":"Successfully emptied"}', (string) $result->getBody());
	}

	/**
	 * Test Deletes an existing bucket function.
	 *
	 * @return void
	 */
	public function testDeleteBucket()
	{
		$bucketId = 'test-bucket-new';
		$result = $this->client->deleteBucket($bucketId);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$this->assertJsonStringEqualsJsonString('{"message":"Successfully deleted"}', (string) $result->getBody());
	}

	/**
	 * Test Invailid bucket id function.
	 *
	 * @return void
	 */
	public function testGetBucketWithInvalidId(): void
	{
		try {
			$result = $this->client->getBucket('not-a-real-bucket-id');
		} catch (\Exception $e) {
			$this->assertEquals('The resource was not found', $e->getMessage());
		}
	}

	/**
	 * Test Creates a new Storage public bucket function.
	 *
	 * @return void
	 */
	public function testCreatePrivateBucket(): void
	{
		$result = $this->client->createBucket('bucket-private', ['public' => false]);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$this->assertJsonStringEqualsJsonString('{"name":"bucket-private"}', (string) $result->getBody());
		$resultInfo = $this->client->getBucket('bucket-private');
		$getValue = json_decode((string) $resultInfo->getBody());
		$isPrivate = $getValue->{'public'};
		$this->assertFalse($isPrivate);
	}
}
