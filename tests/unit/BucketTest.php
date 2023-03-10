<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Supabase\Storage\StorageBucket;

class BucketTest extends TestCase
{
	private $client;

	public function setup(): void
	{
		parent::setUp();
		$dotenv = \Dotenv\Dotenv::createUnsafeImmutable(__DIR__, '/../../.env.test');
		$dotenv->load();
	}

	public function newClient()
	{
		$api_key = getenv('API_KEY');
		$reference_id = getenv('REFERENCE_ID');
		$this->client = new  \Supabase\Storage\StorageClient($api_key, $reference_id);
	}

	/**
	 * Test new StorageBucket().
	 *
	 * @return void
	 */
	public function testNewStorageBucket()
	{
		$client = new  \Supabase\Storage\StorageClient('somekey', 'some_ref_id');
		$this->assertEquals($client->__getUrl(), 'https://some_ref_id.supabase.co/storage/v1');
		$this->assertEquals($client->__getHeaders(), [
			'X-Client-Info' => 'storage-php/0.0.1',
			'Authorization' => 'Bearer somekey',
		]);
	}

	/**
	 * Test Retrieves the details of all Storage buckets within an existing project function.
	 *
	 * @return void
	 */
	public function testListBucket()
	{
		$mock = \Mockery::mock(
			'Supabase\Storage\StorageBucket[__request]',
			['123123123', 'mokerymock']
		);

		$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers) {
			$this->assertEquals('GET', $scheme);
			$this->assertEquals('https://mokerymock.supabase.co/storage/v1/bucket', $url);
			$this->assertEquals([
				'X-Client-Info' => 'storage-php/0.0.1',
				'Authorization' => 'Bearer 123123123',
				'Content-Type' => 'application/json',
			], $headers);

			return true;
		});
		$mock->listBuckets();
	}

	/**
	 * Test Creates a new Storage bucket function.
	 *
	 * @return void
	 */
	public function testCreateBucket()
	{
		$mock = \Mockery::mock(
			'Supabase\Storage\StorageBucket[__request]',
			['123123123', 'mmmmderm']
		);

		$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers, $body) {
			$this->assertEquals('POST', $scheme);
			$this->assertEquals('https://mmmmderm.supabase.co/storage/v1/bucket', $url);
			$this->assertEquals([
				'X-Client-Info' => 'storage-php/0.0.1',
				'Authorization' => 'Bearer 123123123',
				'Content-Type' => 'application/json',
			], $headers);
			$this->assertEquals('{"name":"test","id":"test","public":"true"}', $body);

			return true;
		});

		$mock->createBucket('test', ['public' => true]);
	}

	/**
	 * Test Retrieves the details of an existing Storage bucket function.
	 *
	 * @return void
	 */
	public function testGetBucketWithId()
	{
		$mock = \Mockery::mock(
			'Supabase\Storage\StorageBucket[__request]',
			['123123123', 'mokerymock']
		);

		$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers) {
			$this->assertEquals('GET', $scheme);
			$this->assertEquals('https://mokerymock.supabase.co/storage/v1/bucket', $url);
			$this->assertEquals([
				'X-Client-Info' => 'storage-php/0.0.1',
				'Authorization' => 'Bearer 123123123',
				'Content-Type' => 'application/json',
			], $headers);

			return true;
		});
		$mock->getBucket('test-bucket');
	}

	/**
	 * Test Updates a Storage bucket function.
	 *
	 * @return void
	 */
	public function testUpdateBucket()
	{
		$mock = \Mockery::mock(
			'Supabase\Storage\StorageBucket[__request]',
			['123123123', 'mmmmderm']
		);

		$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers, $body) {
			$this->assertEquals('POST', $scheme);
			$this->assertEquals('https://mmmmderm.supabase.co/storage/v1/bucket/test', $url);
			$this->assertEquals([
				'X-Client-Info' => 'storage-php/0.0.1',
				'Authorization' => 'Bearer 123123123',
				'Content-Type' => 'application/json',
			], $headers);
			$this->assertEquals('{"id":"test","name":"test","public":"true"}', $body);

			return true;
		});

		$mock->updateBucket('test', ['public' => true]);
	}

	public function testUpdateWrongBucket()
	{
		try {
			$mock = \Mockery::mock(
				'Supabase\Storage\StorageBucket[__request]',
				['123123123', 'mmmmderm']
			);

			$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers, $body) {
				$this->assertEquals('POST', $scheme);
				$this->assertEquals('https://mmmmderm.supabase.co/storage/v1/bucket/test', $url);
				$this->assertEquals([
					'X-Client-Info' => 'storage-php/0.0.1',
					'Authorization' => 'Bearer 123123123',
					'Content-Type' => 'application/json',
				], $headers);
				$this->assertEquals('{"id":"test","name":"test","public":"true"}', $body);

				return true;
			});

			$mock->updateBucket('teest', ['public' => true]);
		} catch (\Exception $e) {
			$this->assertEquals('Failed asserting that two strings are equal.', $e->getMessage());
		}
	}

	/**
	 * Test Removes all objects inside a single bucket function.
	 *
	 * @return void
	 */
	public function testEmptyBucket()
	{
		$mock = \Mockery::mock(
			'Supabase\Storage\StorageBucket[__request]',
			['123123123', 'mmmmderm']
		);

		$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers) {
			$this->assertEquals('POST', $scheme);
			$this->assertEquals('https://mmmmderm.supabase.co/storage/v1/bucket/test/empty', $url);
			$this->assertEquals([
				'X-Client-Info' => 'storage-php/0.0.1',
				'Authorization' => 'Bearer 123123123',
				'Content-Type' => 'application/json',
			], $headers);

			return true;
		});

		$mock->emptyBucket('test');
	}

	/**
	 * Test Deletes an existing bucket function.
	 *
	 * @return void
	 */
	public function testDeleteBucket()
	{
		$mock = \Mockery::mock(
			'Supabase\Storage\StorageBucket[__request]',
			['123123123', 'mmmmderm']
		);

		$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers) {
			$this->assertEquals('DELETE', $scheme);
			$this->assertEquals('https://mmmmderm.supabase.co/storage/v1/bucket/test', $url);
			$this->assertEquals([
				'X-Client-Info' => 'storage-php/0.0.1',
				'Authorization' => 'Bearer 123123123',
				'Content-Type' => 'application/json',
			], $headers);

			return true;
		});

		$mock->deleteBucket('test');
	}

	/**
	 * Test Invailid bucket id function.
	 *
	 * @return void
	 */
	public function testGetBucketWithInvalidId()
	{
		try {
			$mock = \Mockery::mock(
				'Supabase\Storage\StorageBucket[__request]',
				['123123123', 'mmmmderm']
			);

			$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers) {
				$this->assertEquals('GET', $scheme);
				$this->assertEquals('https://mmmmderm.supabase.co/storage/v1/bucket/test', $url);
				$this->assertEquals([
					'X-Client-Info' => 'storage-php/0.0.1',
					'Authorization' => 'Bearer 123123123',
					'Content-Type' => 'application/json',
				], $headers);

				return true;
			});

			$mock->getBucket('teest', ['public' => true]);
		} catch (\Exception $e) {
			$this->assertEquals('Failed asserting that two strings are equal.', $e->getMessage());
		}
	}

	// /**  REVIEW IF THIS IS NEEDED
	//  * Test Creates a new Storage public bucket function.
	//  *
	//  * @return void
	//  */
	// public function testCreatePublicBucket(): void
	// {
	// 	$this->newClient();
	// 	$result = $this->client->createBucket('bucket-public', ['public' => true]);
	// 	$this->assertEquals('200', $result->getStatusCode());
	// 	$this->assertEquals('OK', $result->getReasonPhrase());
	// 	$this->assertJsonStringEqualsJsonString('{"name":"bucket-public"}', (string) $result->getBody());
	// 	$resultInfo = $this->client->getBucket('bucket-public');
	// 	$getValue = json_decode((string) $resultInfo->getBody());
	// 	$isPrivate = $getValue->{'public'};
	// 	$this->assertTrue($isPrivate);
	// 	$this->assertNotEmpty($result);
	// }
}
