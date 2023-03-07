<?php

declare(strict_types=1);

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
	 * @dataProvider additionProvider
	 */
	public function testUpload(string $path, string $file_path, array $options): void
	{
		//add try catch and throw error
		$result = $this->client->upload($path, $file_path, $options);
		echo $result->getStatusCode()."\n";
		echo $result->getReasonPhrase()."\n";
		var_dump((string) $result->getBody());
		var_dump(json_decode((string) $result->getBody()));

		ob_flush();
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$this->assertJsonStringEqualsJsonString('{"Key":"test-bucket/testFile.png"}', (string) $result->getBody());
		// $this->assertNull($result); //['error']
		// $this->assertArrayHasKey('data', $result);
	}

	/**
	 * Test Downloads a file from a private bucket.
	 *
	 * @dataProvider additionProvider
	 */
	public function testDownload(string $path, string $file_path, array $options): void
	{
		$result = $this->client->download($path, $options);
		$this->assertNull($result['error']);
		$this->assertArrayHasKey('data', $result);
	}

	/**
	 * Test Downloads a file from a private bucket.
	 *
	 * @dataProvider additionProviderList
	 */
	public function testList(string $path): void
	{
		$result = $this->client->list($path);
		$this->assertNull($result['error']);
		$this->assertArrayHasKey('data', $result);
	}

	/**
	 * Test Replaces an existing file at the specified path with a new one.
	 *
	 * @dataProvider additionProvider
	 */
	public function testUpdate(string $path, string $file_path, array $options): void
	{
		$result = $this->client->update($path, $file_path, $options);
		$this->assertNull($result['error']);
		$this->assertArrayHasKey('data', $result);
	}

	/**
	 * Test Moves an existing file to a new path in the same bucket.
	 *
	 * @dataProvider additionProvider
	 */
	public function testMove(string $from_path, string $to_path): void
	{
		$result = $this->client->move($from_path, $to_path);
		$this->assertNull($result['error']);
		$this->assertArrayHasKey('data', $result);
	}

	/**
	 * Test Copies an existing file to a new path in the same bucket.
	 *
	 * @dataProvider additionProvider
	 */
	public function testCopy(string $from_path, string $to_path): void
	{
		$result = $this->client->copy($from_path, $to_path);
		$this->assertNull($result['error']);
		$this->assertArrayHasKey('data', $result);
	}

	/**
	 * Test Deletes files within the same bucket.
	 *
	 * @dataProvider additionProvider
	 */
	public function testRemove($path): void
	{
		$result = $this->client->remove($path);
		$this->assertNull($result['error']);
		$this->assertArrayHasKey('data', $result);
	}

	/**
	 * Test Creates a signed URL. Use a signed URL to share a file for a fixed amount of time.
	 *
	 * @dataProvider additionProviderSignedUrl
	 */
	public function testCreateSignedUrl($path, $expires, $options): void
	{
		$result = $this->client->createSignedUrl($path, $expires, $options);
		$this->assertNull($result['error']);
		$this->assertArrayHasKey('data', $result);
	}

	public function testGetPublicUrl($path, $expires, $options): void
	{
		$result = $this->client->getPublicUrl($path, $options);
		$this->assertArrayHasKey('data', $result);
	}

	public static function additionProvider(): array
	{
		return [
			['testFile.png', 'https://images.squarespace-cdn.com/content/v1/6351e8dab3ca291bb37a18fb/c097a247-cbdf-4e92-a5bf-6b52573df920/1666314646844.png?format=1500w', ['public' => true]],
		];
	}

	public static function additionProviderSignedUrl(): array
	{
		return [
			['public/image.jpg', 60, ['public' => true]],
		];
	}

	/**
	 * Additional data provider for List.
	 */
	public static function additionProviderList(): array
	{
		return [
			['new-directory'],
		];
	}
}
