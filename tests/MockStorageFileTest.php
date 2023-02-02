<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * MokeStorageFileTest Class.
 */
final class MockStorageFileTest extends TestCase
{
	/**
	 * @dataProvider additionProvider
	 */
	public function testUpload(string $path, string $file_path, array $options): void
	{
		$mock = $this->createMock(\Supabase\Storage\StorageFile::class);
		$mock->method('upload')
			 ->willReturn('url');
		$this->assertSame('url', $mock->upload($path, $file_path, $options));
	}

	/**
	 * @dataProvider additionProvider
	 */
	public function testDownload(string $path, string $file_path, array $options): void
	{
		$mock = $this->createMock(\Supabase\Storage\StorageFile::class);
		$mock->method('download')
			 ->willReturn('url');
		$this->assertSame('url', $mock->download($path, $options));
	}

	/**
	 * Test Downloads a file from a private bucket.
	 *
	 * @dataProvider additionProviderList
	 */
	public function testList(string $path): void
	{
		$mock = $this->createMock(\Supabase\Storage\StorageFile::class);
		$mock->method('list')
			 ->willReturn('url');
		$this->assertSame('url', $mock->list($path));
	}

	/**
	 * @dataProvider additionProvider
	 */
	public function testUpdate(string $path, string $file_path, array $options): void
	{
		$mock = $this->createMock(\Supabase\Storage\StorageFile::class);
		$mock->method('update')
			 ->willReturn('url');
		$this->assertSame('url', $mock->update($path, $file_path, $options));
	}

	/**
	 * @dataProvider additionProvider
	 */
	public function testMove(string $path, string $file_path, array $options): void
	{
		$mock = $this->createMock(\Supabase\Storage\StorageFile::class);
		$mock->method('move')
			 ->willReturn('new/file/path');
		$this->assertSame('new/file/path', $mock->move($path, 'new/file/path'));
	}

	/**
	 * @dataProvider additionProvider
	 */
	public function testRemove(string $path): void
	{
		$mock = $this->createMock(\Supabase\Storage\StorageFile::class);
		$mock->method('remove')
			 ->willReturn('file/path');
		$this->assertSame('file/path', $mock->remove($path));
	}

	/**
	 * @dataProvider additionProvider
	 */
	public function testCreateSignedUrl(string $path, string $file_path, array $options, int $expires): void
	{
		$mock = $this->createMock(\Supabase\Storage\StorageFile::class);
		$mock->method('createSignedUrl')
			 ->willReturn('create-signed-url');
		$this->assertSame('create-signed-url', $mock->createSignedUrl($path, $expires, $options));
	}

	/**
	 * @dataProvider additionProvider
	 */
	public function testGetPublicUrl(string $path, string $file_path, array $options): void
	{
		$mock = $this->createMock(\Supabase\Storage\StorageFile::class);
		$mock->method('getPublicUrl')
			 ->willReturn('create-public-url');
		$this->assertSame('create-public-url', $mock->getPublicUrl($path, $options));
	}

	/**
	 * Additional data provider.
	 */
	public function additionProvider(): array
	{
		return [
			['path/to/file', 'local/path/to/file/', ['public' => true], 60],
		];
	}

	/**
	 * Additional data provider for List.
	 */
	public function additionProviderList(): array
	{
		return [
			['new-directory'],
		];
	}
}
