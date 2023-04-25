<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Supabase\Storage\StorageClient;

class BucketTest extends TestCase
{
	public function tearDown(): void
	{
		parent::tearDown();
		\Mockery::close();
	}

	/**
	 * Test new StorageClient().
	 *
	 * @return void
	 */
	public function testNewStorageClient()
	{
		$client = new  StorageClient('somekey', 'some_ref_id');
		$this->assertEquals($client->__getUrl(), 'https://some_ref_id.supabase.co/storage/v1');
		$this->assertEquals($client->__getHeaders(), [
			'X-Client-Info' => 'storage-php/0.0.1',
			'Content-Type' => 'application/json',
			'Authorization' => 'Bearer somekey',
		]);
	}

	/**
	 * Test the request parameters needed for Retrieving the details of all Storage buckets within an existing project function.
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
	 * Test the request parameters needed for creating a new Storage bucket function.
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
	 * Test the request parameters needed for Retrieving the details of an existing Storage bucket function.
	 */
	public function testGetBucketWithId()
	{
		$mock = \Mockery::mock(
			'Supabase\Storage\StorageBucket[__request]',
			['123123123', 'mokerymock']
		);

		$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers) {
			$this->assertEquals('GET', $scheme);
			$this->assertEquals('https://mokerymock.supabase.co/storage/v1/bucket/test-bucket', $url);
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
	 * Test the request parameters needed for updating a Storage bucket function.
	 */
	public function testUpdateBucket()
	{
		$mock = \Mockery::mock(
			'Supabase\Storage\StorageBucket[__request]',
			['123123123', 'mmmmderm']
		);

		$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers, $body) {
			$this->assertEquals('PUT', $scheme);
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

	/**
	 * Test the request parameters needed for updating a Storage bucket function with error handling for wrong IDs.
	 */
	public function testUpdateWrongBucket()
	{
		try {
			$mock = \Mockery::mock(
				'Supabase\Storage\StorageBucket[__request]',
				['123123123', 'mmmmderm']
			);

			$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers, $body) {
				$this->assertEquals('PUT', $scheme);
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
	 * Test the request parameters needed for removing all objects inside a single bucket function.
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
			], $headers);

			return true;
		});

		$mock->emptyBucket('test');
	}

	/**
	 * Test the request parameters needed for removing  an existing bucket function.
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
			], $headers);

			return true;
		});

		$mock->deleteBucket('test');
	}

	/**
	 * Test error handling for getting an Invailid bucket id function.
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
}
