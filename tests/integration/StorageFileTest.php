<?php

declare(strict_types=1);

use PhpOption\Option;
use PHPUnit\Framework\TestCase;

final class StorageFileTest extends TestCase
{
	private $client;

	/**
	 * The setUp runs for each fuction.
	 */
	public function setup(): void
	{
		parent::setUp();
		$dotenv = \Dotenv\Dotenv::createUnsafeImmutable(__DIR__, '/../../.env.test');
		$dotenv->load();
		$api_key = getenv('API_KEY');
		$reference_id = getenv('REFERENCE_ID');
		$bucket_id = 'test-bucket';
		$this->client = new  \Supabase\Storage\StorageFile($api_key, $reference_id, $bucket_id);
	}

	/**
	 * Test uploads a file to an existing bucket.
	 *
	 * 
	 */
	public function testUpload(): void
	{
		$path = 'testFile.png';
		$file_path = 'https://images.squarespace-cdn.com/content/v1/6351e8dab3ca291bb37a18fb/c097a247-cbdf-4e92-a5bf-6b52573df920/1666314646844.png?format=1500w';
		$options = ['public' => true];
		$result = $this->client->upload($path, $file_path, $options);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$this->assertJsonStringEqualsJsonString('{"Key":"test-bucket/testFile.png"}', (string) $result->getBody());
	}

	/**
	 * Test Downloads a file from a private bucket.
	 *
	 * 
	 */
	public function testDownload(): void
	{
		$path = 'testFile.png';
		$options = ['public' => true];
		$result = $this->client->download($path, $options);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$output = $result->getBody()->getContents();
		file_put_contents('file.png', $output);
	}

	/**
	 * Test Downloads a file from a private bucket.
	 *
	 * 
	 */
	public function testList(): void
	{
		$path = 'path/to';
		$result = $this->client->list($path);
		echo $result->getBody() . "\n";
		ob_flush();
	}

	/**
	 * Test Replaces an existing file at the specified path with a new one.
	 *
	 * 
	 */
	public function testUpdate(): void
	{
		$path = 'testFile.png';
		$file_path = 'https://images.squarespace-cdn.com/content/v1/6351e8dab3ca291bb37a18fb/c097a247-cbdf-4e92-a5bf-6b52573df920/1666314646844.png?format=1500w';
		$options = ['public' => true];
		$result = $this->client->update($path, $file_path, $options);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$this->assertJsonStringEqualsJsonString('{"Key":"test-bucket/testFile.png"}', (string) $result->getBody());
	}

	/**
	 * Test Moves an existing file to a new path in the same bucket.
	 *
	 * 
	 */
	public function testMove(): void
	{
		$bucket_id = 'test-bucket';
		$from_path = 'testFile.png';
		$to_path = 'path/testFile.png';
		$result = $this->client->move($bucket_id, $from_path, $to_path);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$this->assertJsonStringEqualsJsonString('{"message": "Successfully moved"}', (string) $result->getBody());
	}

	/**
	 * Test Copies an existing file to a new path in the same bucket.
	 *
	 * 
	 */
	public function testCopy(): void
	{
		$from_path = 'testFile.png';
		$bucket_id = 'test-bucket';
		$to_path = 'path/to/testFile.png';
		$result = $this->client->copy($from_path, $bucket_id, $to_path);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$this->assertJsonStringEqualsJsonString('{"Key": "test-bucket/path/to/testFile.png"}', (string) $result->getBody());
	}

	/**
	 * Test Deletes files within the same bucket.
	 *
	 * 
	 */
	public function testRemove($path): void
	{
		$path = 'path/to/testFile.png';
		$result = $this->client->remove($path);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$this->assertJsonStringEqualsJsonString('{"message": "Successfully deleted"}', (string) $result->getBody());
	}

	/**
	 * Test Creates a signed URL. Use a signed URL to share a file for a fixed amount of time.
	 *
	 * 
	 */
	public function testCreateSignedUrl(): void
	{
		$path = 'path/to/file.png';
		$expires = 60;
		$result = $this->client->createSignedUrl($path, $expires);
		echo (string) $result->getBody();
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		ob_flush();
	}

	public function testGetPublicUrl(): void
	{
		$path = 'path/to/file.png';
		$options = ['download'];
		$result = $this->client->getPublicUrl($path, $options);
		echo (string) $result->getBody();
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		ob_flush();
	}
}
