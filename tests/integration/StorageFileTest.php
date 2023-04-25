<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Supabase\Storage\Util\EnvSetup;

final class StorageFileTest extends TestCase
{
	private $client;

	public function uploadFile($public = true, $file_path = null): array
	{
		$path = 'testFile-'.uniqid().'.png';
		$file_path = $file_path ? $file_path : __DIR__.'/../fixtures/test-file.png';
		$result = $this->client->upload($path, $file_path, ['public' => $public]);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$this->assertJsonStringEqualsJsonString('{"Key":"test-bucket/'.$path.'"}', (string) $result->getBody());

		return [
			$result,
			$path,
		];
	}

	private function deleteFile($file): void
	{
		$result = $this->client->remove([$file]);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		// @TODO - understand why there is no response for this call
//		$this->assertJsonStringEqualsJsonString('{"message":"Successfully deleted"}', (string) $result->getBody());
	}

	/**
	 * The setUp runs for each fuction.
	 */
	public function setup(): void
	{
		parent::setUp();
		$keys = EnvSetup::env(__DIR__.'/../');
		$api_key = $keys['API_KEY'];
		$reference_id = $keys['REFERENCE_ID'];

		$c = new \Supabase\Storage\StorageClient($api_key, $reference_id);
		$this->client = $c->from('test-bucket');
	}

	/**
	 * Test uploads a file to an existing bucket.
	 */
	public function testUpload(): void
	{
		// Upload from URL
		$file_path = 'https://images.squarespace-cdn.com/content/v1/6351e8dab3ca291bb37a18fb/c097a247-cbdf-4e92-a5bf-6b52573df920/1666314646844.png?format=1500w';
		[ $result, $path ] = $this->uploadFile(true, $file_path);
		$this->deleteFile($path);

		// Upload from local fixture
		[ $result, $path ] = $this->uploadFile();
		$this->deleteFile($path);
	}

	/**
	 * Test Downloads a file from a private bucket.
	 */
	public function testDownload(): void
	{
		[ $setup, $path ] = $this->uploadFile();
		$result = $this->client->download($path);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$output = $result->getBody()->getContents();
		$this->assertEquals(11830, strlen($output));
		$this->assertEquals('650928b71c38af56610adcd1d78bbcb3', md5($output));
		$this->deleteFile($path);
	}

	/**
	 * Test Downloads a file from a private bucket.
	 */
	public function testList(): void
	{
		$result = $this->client->list('');
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$body = $result->getBody()->getContents();
		$this->assertNotEmpty($body);
		// @TODO - test for a thing in the list
	}

	/**
	 * Test Replaces an existing file at the specified path with a new one.
	 */
	public function testUpdate(): void
	{
		[ $setup, $path ] = $this->uploadFile();

		$newFile = 'https://images.squarespace-cdn.com/content/v1/6351e8dab3ca291bb37a18fb/c097a247-cbdf-4e92-a5bf-6b52573df920/1666314646844.png?format=1500w';

		$result = $this->client->update($path, $newFile, ['public' => true]);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$this->assertJsonStringEqualsJsonString('{"Key":"test-bucket/'.$path.'"}', (string) $result->getBody());

		$result = $this->client->download($path);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$output = $result->getBody()->getContents();

		$this->assertEquals(11830, strlen($output));
		$this->assertEquals('650928b71c38af56610adcd1d78bbcb3', md5($output));
		$this->deleteFile($path);
	}

	/**
	 * Test Moves an existing file to a new path in the same bucket.
	 */
	public function testMove(): void
	{
		[ $setup, $path ] = $this->uploadFile();
		$from_path = $path;
		$to_path = 'new-path/'.$path;
		$result = $this->client->move($from_path, $to_path);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$this->assertJsonStringEqualsJsonString('{"message": "Successfully moved"}', (string) $result->getBody());
		$this->deleteFile($to_path);
	}

	/**
	 * Test Copies an existing file to a new path in the same bucket.
	 */
	public function testCopy(): void
	{
		[ $setup, $path ] = $this->uploadFile();
		$to_path = 'path/'.$path;
		$result = $this->client->copy($path, $to_path);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$this->assertJsonStringEqualsJsonString('{"Key": "test-bucket/path/'.$path.'"}', (string) $result->getBody());
		$this->deleteFile($path);
		$this->deleteFile($to_path);
	}

	/**
	 * Test Deletes files within the same bucket.
	 */
	public function testRemove(): void
	{
		[ $setup, $path ] = $this->uploadFile();
		$resultDelete = $this->client->remove($path);
		$this->assertEquals('200', $resultDelete->getStatusCode());
		$this->assertEquals('OK', $resultDelete->getReasonPhrase());
		$payload = json_decode((string) $resultDelete->getBody());
		$this->assertNotEmpty($payload);
	}

	/**
	 * Test Creates a signed URL. Use a signed URL to share a file for a fixed amount of time.
	 */
	public function testCreateSignedUrl(): void
	{
		[ $setup, $path ] = $this->uploadFile();
		$expires = 60;
		$result = $this->client->createSignedUrl($path, $expires);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$payload = json_decode((string) $result->getBody());
		$this->assertStringContainsString(
			"/render/image/sign/test-bucket/{$path}?token=",
			$payload->{'signedURL'}
		);
		$this->deleteFile($path);
	}

	/**
	 * Test Creates a signed URL. Use a signed URL to share a file for a fixed amount of time from a public bucket.
	 */
	public function testGetPublicUrl(): void
	{
		[ $setup, $path ] = $this->uploadFile();
		$url = $this->client->getPublicUrl($path);
		$this->assertStringContainsString(
			"/storage/v1/object/public/test-bucket/{$path}",
			$url
		);
		$this->deleteFile($path);
	}
}
