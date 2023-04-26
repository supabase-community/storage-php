<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Supabase\Storage\StorageFile;

class FileTest extends TestCase
{
	public function tearDown(): void
	{
		parent::tearDown();
		\Mockery::close();
	}

	/**
	 * Test the request parameters for new storage file.
	 */
	public function testNewStorageFile()
	{
		$client = new StorageFile('somekey', 'some_ref_id', 'someBucket');
		$this->assertEquals($client->__getUrl(), 'https://some_ref_id.supabase.co/storage/v1');
		$this->assertEquals($client->__getHeaders(), [
			'X-Client-Info' => 'storage-php/0.0.1',
			'Authorization' => 'Bearer somekey',
			'Content-Type' => 'application/json',
		]);
		$this->assertEquals($client->__getBucketId(), 'someBucket');
	}

	/**
	 * Test the request parameters for a list cket response.
	 */
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
					'Content-Type' => 'application/json',
				],
				$headers
			);
			$this->assertEquals('{"prefix":"someBucket","limit":100,"offset":0,"sortBy":{"column":"name","order":"asc"}}', $body);

			return true;
		});

		$mock->list('someBucket');
	}

	/**
	 * Test the request parameters for uploads a file to an existing bucket.
	 */
	public function testUpload()
	{
		$mockFile = \Mockery::mock('alias:Supabase\Storage\Util\FileHandler');
		$mockFile->shouldReceive('getFileContents')->andReturn('Bruno Estera');

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
					'Content-Type' => 'image/png',
					'x-upsert' => 'false',
				],
				$headers
			);

			$this->assertEquals('Bruno Estera', $body);

			return true;
		});

		$mock->upload('testFile.png', 'testFile', ['public' => true]);
	}

	/**
	 * Test the request parameters for Downloading a file from a private bucket.
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
					'Content-Type' => 'application/json',
					'stream' => true,
				],
				$headers
			);

			return true;
		});

		$mock->download('someBucket');
	}

	/**
	 * Test the request parameters for replacing an existing file at the specified path with a new one.
	 */
	public function testUpdate()
	{
		$mockFile = \Mockery::mock('alias:Supabase\Storage\Util\FileHandler');
		$mockFile->shouldReceive('getFileContents')->andReturn('Isla Ian');

		$mock = \Mockery::mock(
			'Supabase\Storage\StorageFile[__request]',
			['123123123', 'mmmmderm', 'someBucket']
		);

		$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers, $body) {
			$this->assertEquals('PUT', $scheme);
			$this->assertEquals('https://mmmmderm.supabase.co/storage/v1/object/someBucket/testFile.jpeg', $url);
			$this->assertEquals(
				[
					'X-Client-Info' => 'storage-php/0.0.1',
					'Authorization' => 'Bearer 123123123',
					'Content-Type' => 'image/jpeg',
				],
				$headers
			);

			$this->assertEquals('Isla Ian', $body);

			return true;
		});

		$mock->update('testFile.jpeg', 'exampleFile', ['public' => true]);
	}

	/**
	 * Test the request parameters for moving an existing file to a new path in the same bucket.
	 */
	public function testMove()
	{
		$mock = \Mockery::mock(
			'Supabase\Storage\StorageFile[__request]',
			['123123123', 'mmmmderm', 'moveBucket']
		);

		$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers, $body) {
			$this->assertEquals('POST', $scheme);
			$this->assertEquals('https://mmmmderm.supabase.co/storage/v1/object/move', $url);
			$this->assertEquals(
				[
					'X-Client-Info' => 'storage-php/0.0.1',
					'Authorization' => 'Bearer 123123123',
					'Content-Type' => 'application/json',
				],
				$headers
			);
			$this->assertEquals('{"bucketId":"moveBucket","sourceKey":"existing\/path\/file.png","destinationKey":"new\/path\/ink.png"}', $body);

			return true;
		});

		$mock->move('existing/path/file.png', 'new/path/ink.png');
	}

	/**
	 * Test the request parameters needed for copying an existing file to a new path in the same bucket.
	 */
	public function testCopy()
	{
		$mock = \Mockery::mock(
			'Supabase\Storage\StorageFile[__request]',
			['123123123', 'mmmmderm', 'copyBucket']
		);

		$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers, $body) {
			$this->assertEquals('POST', $scheme);
			$this->assertEquals('https://mmmmderm.supabase.co/storage/v1/object/copy', $url);
			$this->assertEquals(
				[
					'X-Client-Info' => 'storage-php/0.0.1',
					'Authorization' => 'Bearer 123123123',
					'Content-Type' => 'application/json',
				],
				$headers
			);
			$this->assertEquals('{"bucketId":"copyBucket","sourceKey":"existing\/path\/file.png","destinationKey":"new\/path\/copy.png"}', $body);

			return true;
		});

		$mock->copy('existing/path/file.png', 'new/path/copy.png');
	}

	/**
	 * Test the request parameters needed for deleting files within the same bucket.
	 */
	public function testRemove()
	{
		$mock = \Mockery::mock(
			'Supabase\Storage\StorageFile[__request]',
			['123123123', 'mmmmderm', 'someBucket']
		);

		$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers, $body) {
			$this->assertEquals('DELETE', $scheme);
			$this->assertEquals('https://mmmmderm.supabase.co/storage/v1/object/someBucket', $url);
			$this->assertEquals(
				[
					'X-Client-Info' => 'storage-php/0.0.1',
					'Authorization' => 'Bearer 123123123',
					'Content-Type' => 'application/json',
				],
				$headers
			);
			$this->assertEquals('{"prefixes":["exampleFolder\/exampleFile.png"]}', $body);

			return true;
		});

		$mock->remove(['exampleFolder/exampleFile.png']);
	}

	/**
	 * Test the request parameters needed for creating a signed URL. Use a signed URL to share a file for a fixed amount of time.
	 */
	public function testCreateSignedUrl()
	{
		$mock = \Mockery::mock(
			'Supabase\Storage\StorageFile[__request]',
			['123123123', 'mmmmderm', 'someBucket']
		);

		$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers, $body) {
			$this->assertEquals('POST', $scheme);
			$this->assertEquals('https://mmmmderm.supabase.co/storage/v1/object/sign/someBucket/exampleFolder/exampleFile.png', $url);
			$this->assertEquals(
				[
					'X-Client-Info' => 'storage-php/0.0.1',
					'Authorization' => 'Bearer 123123123',
					'Content-Type' => 'application/json',
				],
				$headers
			);
			$this->assertEquals('{"expiresIn":60,"transform":{"height":100,"width":100,"resize":"cover","format":"origin","quality":100}}', $body);

			return true;
		});

		$mock->createSignedUrl('exampleFolder/exampleFile.png', 60);
	}

	/**
	 * Test the request parameters needed for creating a signed URL. Use a signed URL to share a file for a fixed amount of time.
	 */
	public function testCreateSignedUrls()
	{
		$mockResponse = \Mockery::mock(
			'Psr\Http\Message\ResponseInterface[getBody]'
		);
		$mockResponse->shouldReceive('getBody')->andReturn('
			[{"error":null,"path":"test-file.jpg","signedURL":"/object/sign/test-bucket/test-file.jpg?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJ0ZXN0LWJ1Y2tldC90ZXN0LWZpbGUuanBnIiwiaWF0IjoxNjc4NzQ1ODY4LCJleHAiOjE2Nzg3NDU5Mjh9.47gIm3sPofALRdJEy3nR-cgnie2boloezGJkDnKy_5g"},{"error":"Either the object does not exist or you do not have access to it","path":"path/to/file-base64.png","signedURL":null}]
		');

		$mock = \Mockery::mock(
			'Supabase\Storage\StorageFile[__request]',
			['123123123', 'mmmmderm', 'someBucket']
		);

		$mock->shouldReceive('__request')->withArgs(function ($scheme, $url, $headers, $body) {
			$this->assertEquals('POST', $scheme);
			$this->assertEquals('https://mmmmderm.supabase.co/storage/v1/object/sign/someBucket', $url);
			$this->assertEquals(
				[
					'X-Client-Info' => 'storage-php/0.0.1',
					'Authorization' => 'Bearer 123123123',
					'Content-Type' => 'application/json',
				],
				$headers
			);
			$this->assertEquals('{"paths":"exampleFolder\/exampleFile.png","expiresIn":60,"options":"download"}', $body);

			return true;
		})->andReturn($mockResponse);

		$data = $mock->createSignedUrls('exampleFolder/exampleFile.png', 60, 'download');
		$this->assertCount(2, $data);
		$this->assertCount(3, $data[0]);
		$this->assertCount(3, $data[1]);
		$this->assertEqualsCanonicalizing([null, 'https://mmmmderm.supabase.co/storage/v1/object/sign/test-bucket/test-file.jpg?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJ0ZXN0LWJ1Y2tldC90ZXN0LWZpbGUuanBnIiwiaWF0IjoxNjc4NzQ1ODY4LCJleHAiOjE2Nzg3NDU5Mjh9.47gIm3sPofALRdJEy3nR-cgnie2boloezGJkDnKy_5g', 'test-file.jpg'], $data[0]);
		$this->assertEqualsCanonicalizing('Either the object does not exist or you do not have access to it', 'Either the object does not exist or you do not have access to it', '', $data[1]);
	}

	/**
	 * Test the request parameters needed for creating a public URL. Use a signed URL to share a file for a fixed amount of time.
	 */
	public function testGetPublicUrl()
	{
		$mock = \Mockery::mock(
			'Supabase\Storage\StorageFile[__request]',
			['123123123', 'mmmmderm', 'someBucket']
		);

		$url = $mock->getPublicUrl('exampleFolder/exampleFile.png', ['download' => true]);
		$this->assertEquals('https://mmmmderm.supabase.co/storage/v1/object/public/someBucket/exampleFolder/exampleFile.png?download=true', $url);
	}
}
