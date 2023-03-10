<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
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
		$bucketId = 'test-bucket';
		$this->client = new  \Supabase\Storage\StorageFile($api_key, $reference_id, $bucketId);
	}

	/**
	 * Test new storage file.
	 */
	public function testNewStorageFile()
	{
		$client = new  \Supabase\Storage\StorageFile('somekey', 'some_ref_id', 'someBucket');
		$this->assertEquals($client->__getUrl(), 'https://some_ref_id.supabase.co/storage/v1');
		$this->assertEquals($client->__getHeaders(), [
			'X-Client-Info' => 'storage-php/0.0.1',
			'Authorization' => 'Bearer somekey',
		]);
		$this->assertEquals($client->__getBucketId(), 'someBucket');
	}

	public function testList()
	{
		$mock = \Mockery::mock(
			'Supabase\Storage\StorageFile[__request]',
			['123123123', 'mmmmderm', 'someBucket']
		);

		$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers, $body) {
			$this->assertEquals('POST', $scheme);
			$this->assertEquals('https://mmmmderm.supabase.co/storage/v1/object/list/someBucket', $url);
			$this->assertEquals(
				[
					'X-Client-Info' => 'storage-php/0.0.1',
					'Authorization' => 'Bearer 123123123',
					'content-type' => 'application/json',
				],
				$headers
			);
			$this->assertEquals('{"prefix":"someBucket","limit":100,"offset":0,"sortBy":{"column":"name","order":"asc"}}', $body);

			return true;
		});

		$mock->list('someBucket');
	}

	/**
	 * Test uploads a file to an existing bucket.
	 */
	public function testUpload()
	{
		$mock = \Mockery::mock(
			'Supabase\Storage\StorageFile[__request]',
			['123123123', 'mmmmderm', 'someBucket']
		);

		$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers, $body) {
			$this->assertEquals('POST', $scheme);
			$this->assertEquals('https://mmmmderm.supabase.co/storage/v1/object/someBucket/testFile.png', $url);
			$this->assertEquals(
				[
					'X-Client-Info' => 'storage-php/0.0.1',
					'Authorization' => 'Bearer 123123123',
					'Content-Type' => 'application/json',
					'x-upsert' => 'false',
				],
				$headers
			);
			//$this->assertEquals('{"name":"test","id":"test","public":"true"}', $body);

			return true;
		});

		$mock->upload('testFile.png', 'https://images.squarespace-cdn.com/content/v1/6351e8dab3ca291bb37a18fb/c097a247-cbdf-4e92-a5bf-6b52573df920/1666314646844.png?format=1500w', ['public' => true]);
	}

	/**
	 * Test Downloads a file from a private bucket.
	 */
	public function testDownload(): void
	{
		$mock = \Mockery::mock(
			'Supabase\Storage\StorageFile[__request]',
			['123123123', 'mmmmderm', 'someBucket']
		);

		$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers) {
			$this->assertEquals('GET', $scheme);
			$this->assertEquals('https://mmmmderm.supabase.co/storage/v1/object/someBucket/someBucket', $url);
			$this->assertEquals(
				[
					'X-Client-Info' => 'storage-php/0.0.1',
					'Authorization' => 'Bearer 123123123',
					'stream' => true,
				],
				$headers
			);

			return true;
		});

		$mock->download('someBucket');
	}

	/**
	 * Test Replaces an existing file at the specified path with a new one.
	 */
	public function testUpdate()
	{
		$mock = \Mockery::mock(
			'Supabase\Storage\StorageFile[__request]',
			['123123123', 'mmmmderm', 'someBucket']
		);

		$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers, $body) {
			$this->assertEquals('PUT', $scheme);
			$this->assertEquals('https://mmmmderm.supabase.co/storage/v1/object/someBucket/testFile.png', $url);
			$this->assertEquals(
				[
					'X-Client-Info' => 'storage-php/0.0.1',
					'Authorization' => 'Bearer 123123123',
					'Content-Type' => 'application/json',
					'content-type' => 'text/plain;charset=UTF-8',
				],
				$headers
			);
			//$this->assertEquals('{"name":"test","id":"test","public":"true"}', $body);

			return true;
		});

		$mock->update('testFile.png', 'exampleFile', ['public' => true]);
	}

	/**
	 * Test Moves an existing file to a new path in the same bucket.
	 */
	public function testMove()
	{
		$mock = \Mockery::mock(
			'Supabase\Storage\StorageFile[__request]',
			['123123123', 'mmmmderm', 'someBucket']
		);

		$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers, $body) {
			$this->assertEquals('POST', $scheme);
			$this->assertEquals('https://mmmmderm.supabase.co/storage/v1/object/move', $url);
			$this->assertEquals(
				[
					'X-Client-Info' => 'storage-php/0.0.1',
					'Authorization' => 'Bearer 123123123',
					'content-type' => 'application/json',
				],
				$headers
			);
			$this->assertEquals('{"bucketId":"someBucket","sourceKey":"fromBucket","destinationKey":"toBucket"}', $body);

			return true;
		});

		$mock->move('someBucket', 'fromBucket', 'toBucket');
	}

	/**
	 * Test Copies an existing file to a new path in the same bucket.
	 */
	public function testCopy()
	{
	}

	/**
	 * Test Deletes files within the same bucket.
	 */
	public function testRemove()
	{
	}

	/**
	 * Test Creates a signed URL. Use a signed URL to share a file for a fixed amount of time.
	 */
	public function testCreateSignedUrl()
	{
	}

	/**
	 * Test Creates a public URL. Use a signed URL to share a file for a fixed amount of time.
	 */
	public function testGetPublicUrl()
	{
	}
}
