<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Supabase\Storage\Util\EnvSetup;

final class StorageBucketTest extends TestCase
{
	private $client;

	private function createBucket($public = true): array
	{
		$bucketName = 'bucket'.uniqid();
		$result = $this->client->createBucket($bucketName, ['public' => $public]);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$payload = (string) $result->getBody();
		$this->assertJsonStringEqualsJsonString(
			json_encode(['name' => $bucketName]),
			$payload
		);

		return [$bucketName, $result];
	}

	private function deleteBucket($bucketName): void
	{
		$result = $this->client->deleteBucket($bucketName);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$this->assertJsonStringEqualsJsonString('{"message":"Successfully deleted"}', (string) $result->getBody());
	}

	public function setup(): void
	{
		parent::setUp();

		$keys = EnvSetup::env(__DIR__.'/../');
		$api_key = $keys['API_KEY'];
		$reference_id = $keys['REFERENCE_ID'];

		$this->client = new \Supabase\Storage\StorageClient($api_key, $reference_id);
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
		[ $bucketName, $result ] = $this->createBucket();
		$getValue = json_decode((string) $result->getBody());
		$obj = $getValue->{'name'};
		$this->assertEquals($bucketName, $obj);
		$this->deleteBucket($bucketName);
	}

	/**
	 * Test Retrieves the details of an existing Storage bucket function.
	 *
	 * @return void
	 */
	public function testGetBucketWithId(): void
	{
		[ $bucketName, $result ] = $this->createBucket();
		$bucket = $this->client->getBucket($bucketName);
		$this->assertEquals('200', $bucket->getStatusCode());
		$this->assertEquals('OK', $bucket->getReasonPhrase());
		$getValue = json_decode((string) $bucket->getBody());
		$obj = $getValue->{'id'};
		$this->assertEquals($bucketName, $obj);
		$this->deleteBucket($bucketName);
	}

	/**
	 * Test Updates a Storage bucket function.
	 *
	 * @return void
	 */
	public function testUpdateBucket(): void
	{
		[ $bucketName, $result ] = $this->createBucket();
		$result = $this->client->updateBucket($bucketName, ['public' => true]);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$this->assertJsonStringEqualsJsonString('{"message":"Successfully updated"}', (string) $result->getBody());
		$result = $this->deleteBucket($bucketName);
	}

	/**
	 * Test Removes all objects inside a single bucket function.
	 *
	 * @return void
	 */
	public function testEmptyBucket()
	{
		[ $bucketName, $result ] = $this->createBucket();
		$result = $this->client->emptyBucket($bucketName);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$this->assertJsonStringEqualsJsonString('{"message":"Successfully emptied"}', (string) $result->getBody());
		$result = $this->deleteBucket($bucketName);
	}

	/**
	 * Test Deletes an existing bucket function.
	 *
	 * @return void
	 */
	public function testDeleteBucket()
	{
		[ $bucketName, $result ] = $this->createBucket();
		$result = $this->client->deleteBucket($bucketName);
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
			$this->client->getBucket('not-a-real-bucket-id');
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
		[ $bucketName, $result ] = $this->createBucket(false);
		$resultInfo = $this->client->getBucket($bucketName);
		$payload = json_decode((string) $resultInfo->getBody());
		$this->assertFalse($payload->{'public'});
		$result = $this->deleteBucket($bucketName);
	}
}
