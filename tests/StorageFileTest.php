<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

// TODO: Make StorageClient init with supplied secrets.
// i.e. StorageClient('https://abc.supabase.co/storage/v1', ['Authorization' => 'Bearer ' . 'SECRET])

final class StorageFileTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     */

    public function testUpload(string $path, string $file_path, array $options): void
    {
        $storage = $this->createStub(\Supabase\Storage\StorageFile::class);
        $storage->method('upload')
             ->willReturn('url');
        $this->assertSame('url', $storage->upload($path, $file_path, $options));
    }

    /**
     * @dataProvider additionProvider
     */

    public function testDownload(string $path, string $file_path, array $options): void
    {   
        $storage = $this->createStub(\Supabase\Storage\StorageFile::class);
        $storage->method('download')
             ->willReturn('url');
        $this->assertSame('url', $storage->download($path, $options));
    }

    /**
     * @dataProvider additionProvider
     */

    public function testUpdate(string $path, string $file_path, array $options): void
    {
        $storage = $this->createStub(\Supabase\Storage\StorageFile::class);
        $storage->method('update')
             ->willReturn('url');
        print_r($storage);
        $this->assertSame('url', $storage->update($path, $file_path, $options ));
    }

    public function testMove(): void
    {
        $url = 'https://<project_ref>.supabase.co/storage/v1';
        $service_key = '<service_role>';
        $storage = new \Supabase\Storage\StorageFile($url, [
            'Authorization' => 'Bearer ' . $service_key,
           ], 'my-new-storage-bucket-public-test');
        
        //$file = file_get_contents('/home/tesillos/Documents/Adolfo/test.txt', true);
        $result = $storage->move('nuevo/imagen.bmp', 'new/imagen-change.bmp');
        $this->assertNull($result['error']);
        $this->assertArrayHasKey('data', $result);
    }

    public function testRemove(): void
    {
        $url = 'https://<project_ref>.supabase.co/storage/v1';
        $service_key = '<service_role>';
        $storage = new \Supabase\Storage\StorageFile($url, [
            'Authorization' => 'Bearer ' . $service_key,
           ], 'my-new-storage-bucket-public-test');
        
        //$file = file_get_contents('/home/tesillos/Documents/Adolfo/test.txt', true);
        $result = $storage->remove('new/imagen-change.bmp');
        $this->assertNull($result['error']);
        $this->assertArrayHasKey('data', $result);
    }

    public function testCreateSignedUrl(): void
    {
        $url = 'https://<project_ref>.supabase.co/storage/v1';
        $service_key = '<service_role>';
        $expires = 60;
        $storage = new \Supabase\Storage\StorageFile($url, [
            'Authorization' => 'Bearer ' . $service_key,
           ], 'my-new-storage-bucket-public-test');
        
        //$file = file_get_contents('/home/tesillos/Documents/Adolfo/test.txt', true);
        $result = $storage->createSignedUrl('public/imagen.bmp', $expires, []);
        $this->assertNull($result['error']);
        $this->assertArrayHasKey('data', $result);
    }

    public function testGetPublicUrl(): void
    {
        $url = 'https://<project_ref>.supabase.co/storage/v1';
        $service_key = '<service_role>';
        $expires = 60;
        $storage = new \Supabase\Storage\StorageFile($url, [
            'Authorization' => 'Bearer ' . $service_key,
           ], 'my-new-storage-bucket-public-test');
        $result = $storage->getPublicUrl('public/imagen.bmp', []);
        $this->assertArrayHasKey('data', $result);
    }

    public function additionProvider(): array
    {
        return [
            ['path/to/file', 'local/path/to/file/', ['public' => true]],
        ];
    }
    
}
