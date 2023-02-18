<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class VCRStorageFileTest extends TestCase
{
	private $client;

	/**
	 * The setUp runs for each fuction.
	 */
	public function setup(): void
	{
		parent::setUp();
		$authHeader = ['Authorization' => 'Bearer '.$_ENV['SERVICE_ROLE']];
		$bucket_id = 'my-new-storage-bucket-vcr';
		$this->client = new  \Supabase\Storage\StorageFile('https://'.$_ENV['PROJECT_REF'].'.supabase.co/storage/v1',
		 $authHeader, $bucket_id);
	}

	/**
	 * Test uploads a file to an existing bucket.
	 *
	 * @dataProvider additionProvider
	 */
	public function testUpload(string $path, string $file_path, array $options): void
	{
		\VCR\VCR::turnOn();
		\VCR\VCR::insertCassette('unit_storage_file_test');
		$result = $this->client->upload($path, $file_path, $options);
		$this->assertNotEmpty($result);
		\VCR\VCR::eject();
		\VCR\VCR::turnOff();
	}

	/**
	 * Test Downloads a file from a private bucket.
	 *
	 * @dataProvider additionProvider
	 */
	public function testDownload(string $path, string $file_path, array $options): void
	{
		\VCR\VCR::turnOn();
		\VCR\VCR::insertCassette('unit_storage_file_test');
		$result = $this->client->download($path, $options);
		$this->assertNotEmpty($result);
		\VCR\VCR::eject();
		\VCR\VCR::turnOff();
	}

	/**
	 * Test Replaces an existing file at the specified path with a new one.
	 *
	 * @dataProvider additionProvider
	 */
	public function testUpdate(string $path, string $file_path, array $options): void
	{
		\VCR\VCR::turnOn();
		\VCR\VCR::insertCassette('unit_storage_file_test');
		$result = $this->client->update($path, $file_path, $options);
		$this->assertNotEmpty($result);
		\VCR\VCR::eject();
		\VCR\VCR::turnOff();
	}

	/**
	 * Test Moves an existing file to a new path in the same bucket.
	 *
	 * @dataProvider additionProviderMove
	 */
	public function testMove(string $from_path, string $to_path): void
	{
		\VCR\VCR::turnOn();
		\VCR\VCR::insertCassette('unit_storage_file_test');
		$result = $this->client->move($from_path, $to_path);
		$this->assertNotEmpty($result);
		\VCR\VCR::eject();
		\VCR\VCR::turnOff();
	}

	/**
	 * Test Copies an existing file to a new path in the same bucket.
	 *
	 * @dataProvider additionProviderCopy
	 */
	public function testCopy(string $from_path, string $to_path): void
	{
		\VCR\VCR::turnOn();
		\VCR\VCR::insertCassette('unit_storage_file_test');
		$result = $this->client->copy($from_path, $to_path);
		$this->assertNotEmpty($result);
		\VCR\VCR::eject();
		\VCR\VCR::turnOff();
	}

	/**
	 * Test Deletes files within the same bucket.
	 *
	 * @dataProvider additionProviderRemove
	 */
	public function testRemove($path): void
	{
		\VCR\VCR::turnOn();
		\VCR\VCR::insertCassette('unit_storage_file_test');
		$result = $this->client->remove($path);
		$this->assertNotEmpty($result);
		\VCR\VCR::eject();
		\VCR\VCR::turnOff();
	}

	/**
	 * Test Creates a signed URL. Use a signed URL to share a file for a fixed amount of time.
	 *
	 * @dataProvider additionProviderSignedUrl
	 */
	public function testCreateSignedUrl($path, $expires, $options): void
	{
		\VCR\VCR::turnOn();
		\VCR\VCR::insertCassette('unit_storage_file_test');
		$result = $this->client->createSignedUrl($path, $expires, $options);
		$this->assertNotEmpty($result);
		\VCR\VCR::eject();
		\VCR\VCR::turnOff();
	}

	/**
	 * Test Creates a public URL. Use a signed URL to share a file for a fixed amount of time.
	 *
	 * @dataProvider additionProviderPublicUrl
	 */
	public function testGetPublicUrl($path, $options): void
	{
		\VCR\VCR::turnOn();
		\VCR\VCR::insertCassette('unit_storage_file_test');
		$result = $this->client->getPublicUrl($path, $options);
		$this->assertNotEmpty($result);
		\VCR\VCR::eject();
		\VCR\VCR::turnOff();
	}

	public function additionProvider(): array
	{
		return [
			['public/supabase.png', 'https://raw.githubusercontent.com/github/explore/f4ec5347a36e06540a69376753a7c37a8cb5a136/topics/supabase/supabase.png', ['public' => true]],
		];
	}

	public function additionProviderSignedUrl(): array
	{
		return [
			['new-directory/supabase.png', 60, ['public' => true]],
		];
	}

	public function additionProviderPublicUrl(): array
	{
		return [
			['new-directory/supabase.png', ['public' => true]],
		];
	}

	public function additionProviderMove(): array
	{
		return [
			['public/supabase.png', 'new-directory/supabase.png'],
		];
	}

	public function additionProviderCopy(): array
	{
		return [
			['new-directory/supabase.png', 'copy-directory/supabase.png'],
		];
	}

	public function additionProviderRemove(): array
	{
		return [
			['copy-directory/supabase.png'],
		];
	}
}
