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

	public function newClient(): void
	{
		$api_key = getenv('API_KEY');
		$reference_id = getenv('REFERENCE_ID');
		$this->client = new  \Supabase\Storage\StorageClient($api_key, $reference_id);
		$this->client->__getUrl();
		$this->client->__getHeaders();
		ob_flush();
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
		$this->newClient();
		//$result = $this->client->listBuckets();
		//$this->assertNotEmpty($result);

		$url = $this->client->__getUrl();
		$headers = $this->client->__getHeaders();
		$MakeMock = $this->createMock(StorageBucket::class);
		$ListMock = $MakeMock->listBuckets();

		$ListMock
			->expects($this->once())
			->method('__request')
			->with($this->equalTo('GET'), $this->equalTo($url), $this->equalTo($headers));
	}

	/**
	 * Test Creates a new Storage bucket function.
	 *
	 * @return void
	 */
	public function testCreateBucket(): void
	{

		// $this->newClient();
		// $result = $this->client->createBucket('vcr-bucket', ['public' => false]);
		// $this->assertNotEmpty($result);

		$this->newClient();
		// $url = $this->client->__getUrl();
		// $headers = $this->client->__getHeaders();
		$$MakeMock = $this->createMock(StorageBucket::class);
		$CreateBucketMock = $MakeMock->createBucket('vcr-bucket', ['public' => false]);

		$CreateBucketMock
			->expects($this->once())
			->method('createBucket')
			->with($this->equalTo('vcr-bucket'), $this->equalTo($url));
		$this->assertNotEmpty($CreateBucketMock);
	}

	/**
	 * Test Retrieves the details of an existing Storage bucket function.
	 *
	 * @return void
	 */
	public function testGetBucketWithId(): void
	{

		$this->newClient();
		// $result = $this->client->getBucket('vcr-bucket');
		// $this->assertNotEmpty($result);
		$url = $this->client->__getUrl();
		$headers = $this->client->__getHeaders();
		$MakeMock = $this->createMock(StorageBucket::class);
		$GetMock = $MakeMock->getBucket('vcr-bucket');

		$GetMock
			->expects($this->once())
			->method('__request')
			->with($this->equalTo('GET'), $this->equalTo($url), $this->equalTo($headers));
		$this->assertNotEmpty($GetMock);
	}

	/**
	 * Test Updates a Storage bucket function.
	 *
	 * @return void
	 */
	public function testUpdateBucket(): void
	{

		$this->newClient();
		$result = $this->client->updateBucket('vcr-bucket', ['public' => false]);
		$this->assertNotEmpty($result);
	}

	public function testUpdateWrongBucket(): void
	{
		try {
			$this->newClient();
			$result = $this->client->updateBucket('my-new-storage-bucket-vcr-not-existed', ['public' => true]);
			$this->assertNotEmpty($result);
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

		$this->newClient();
		$result = $this->client->emptyBucket('bucket-private');
		$this->assertNotEmpty($result);
	}

	/**
	 * Test Deletes an existing bucket function.
	 *
	 * @return void
	 */
	public function testDeleteBucket(): void
	{

		$this->newClient();
		$result = $this->client->deleteBucket('vcr-bucket');
		$this->assertNotEmpty($result);
	}

	/**
	 * Test Invailid bucket id function.
	 *
	 * @return void
	 */
	public function testGetBucketWithInvalidId(): void
	{
		try {

			$this->newClient();
			$result = $this->client->getBucket('not-a-real-bucket-id');
			$this->assertNotEmpty($result);
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

		$this->newClient();
		$result = $this->client->createBucket('bucket-public', ['public' => true]);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$this->assertJsonStringEqualsJsonString('{"name":"bucket-public"}', (string) $result->getBody());
		$resultInfo = $this->client->getBucket('bucket-public');
		$getValue = json_decode((string) $resultInfo->getBody());
		$isPrivate = $getValue->{'public'};
		$this->assertTrue($isPrivate);
		$this->assertNotEmpty($result);
	}
}
