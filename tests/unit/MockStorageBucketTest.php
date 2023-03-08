<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * MockStorageBucketTest Class.
 */
final class MockStorageBucketTest extends TestCase
{
	/**
	 * Test Creates a new Storage bucket function.
	 *
	 *
	 *
	 * @return void
	 */
	public function testCreateBucket(string $bucket_id): void
	{
		$mock = $this->createMock(\Supabase\Storage\StorageClient::class);
		$mock->method('createBucket')
			->willReturn($bucket_id);
		$this->assertSame($bucket_id, $mock->createBucket($bucket_id));
	}

	/**
	 * Test Retrieves the details of an existing Storage bucket function.
	 *
	 *
	 *
	 * @return ResponseInterface
	 */
	public function testGetBucketWithId(): void
	{
		$bucket_id = 'test-bucket';
		$mock = $this->createMock(\Supabase\Storage\StorageClient::class);
		$mock->method('getBucket')
			->willReturn($bucket_id);
		$this->assertSame($bucket_id, $mock->getBucket($bucket_id));
	}

	/**
	 * Test Retrieves the details of all Storage buckets within an existing project function.
	 *
	 * @return void
	 */
	public function testListBucket(): void
	{
		$mock = $this->createMock(\Supabase\Storage\StorageClient::class);
		$mock->listBuckets();
	}

	/**
	 * Test Updates a Storage bucket function.
	 *
	 *
	 *
	 * @return void
	 */
	public function testUpdateBucket(string $bucket_id, string $new_bucket_id, array $options): void
	{
		$mock = $this->createMock(\Supabase\Storage\StorageClient::class);
		$mock->method('updateBucket')
			->willReturn($new_bucket_id);
		$this->assertSame($new_bucket_id, $mock->updateBucket($new_bucket_id, $options));
	}

	/**
	 * Test Deletes an existing bucket function.
	 *
	 *
	 *
	 * @return void
	 */
	public function testDeleteBucket(string $bucket_id): void
	{
		$mock = $this->createMock(\Supabase\Storage\StorageClient::class);
		$mock->method('deleteBucket')
			->willReturn($bucket_id);
		$this->assertSame($bucket_id, $mock->deleteBucket($bucket_id));
	}

	/**
	 * Test Removes all objects inside a single bucket function.
	 *
	 *
	 *
	 * @return void
	 */
	public function testEmptyBucket(string $bucket_id): void
	{
		$mock = $this->createMock(\Supabase\Storage\StorageClient::class);
		$mock->method('emptyBucket')
			->willReturn($bucket_id);
		$this->assertSame($bucket_id, $mock->emptyBucket($bucket_id));
	}

	/**
	 * Test Invailid bucket id function.
	 *
	 *
	 *
	 * @return void
	 */
	public function testGetBucketWithInvalidId(string $not_real_bucket_id): void
	{
		$mock = $this->createMock(\Supabase\Storage\StorageClient::class);
		$mock->method('getBucket')
			->willReturn($not_real_bucket_id);
		$this->assertSame($not_real_bucket_id, $mock->getBucket($not_real_bucket_id));
	}

	/**
	 * Test Creates a new Storage public bucket function.
	 *
	 *
	 *
	 * @return void
	 */
	public function testCreatePublicBucket(string $bucket_id): void
	{
		$mock = $this->createMock(\Supabase\Storage\StorageClient::class);
		$mock->method('createBucket')
			->willReturn($bucket_id);
		$this->assertSame($bucket_id, $mock->createBucket($bucket_id, ['public' => true]));
	}
}
