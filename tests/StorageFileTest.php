<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class StorageFileTest extends TestCase
{
    private $client;

    /**
     * The setUp runs for each fuction
     */

     public function setup(): void {
        parent::setUp();
        $authHeader = ['Authorization' => 'Bearer ' . '<service_role>'];
        $bucket_id = '<existing-storage-bucket>';
        $this->client = new  \Supabase\Storage\StorageFile('https://<project_ref>.supabase.co/storage/v1',
            $authHeader, $bucket_id);
    }

    /**
     * Test uploads a file to an existing bucket.
     * @dataProvider additionProvider
     */

    public function testUpload(string $path, string $file_path, array $options): void
    {
        $result =  $this->client->upload($path, $file_path, $options);
        $this->assertNull($result['error']);
        $this->assertArrayHasKey('data', $result);
    }

    /**
     * Test Downloads a file from a private bucket.
     * @dataProvider additionProvider
     */

    public function testDownload(string $path, string $file_path, array $options): void
    {   
        $result = $this->client->download($path, $options);
        $this->assertNull($result['error']);
        $this->assertArrayHasKey('data', $result);
    }

    /**
     * Test Replaces an existing file at the specified path with a new one.
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
        $result = $this->getPublicUrl($path, $options);
        $this->assertArrayHasKey('data', $result);
    }

    public function additionProvider(): array
    {
        return [
            ['public/copy-imagen2.jpg', 'public/copy-imagen2.jpg', ['public' => true]],
        ];
    }

    public function additionProviderSignedUrl(): array
    {
        return [
            ['public/image.jpg', 60, ['public' => true]],
        ];
    }    
    
}
