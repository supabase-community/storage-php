<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

// TODO: Make StorageClient init with supplied secrets.
// i.e. StorageClient('https://abc.supabase.co/storage/v1', ['Authorization' => 'Bearer ' . 'SECRET])

final class StorageFileTest extends TestCase
{
    public function testUpload(): void
    {
        $url = 'https://gpdefvsxamnscceccczu.supabase.co/storage/v1';
        $service_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImdwZGVmdnN4YW1uc2NjZWNjY3p1Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTY3MDAwOTgxNCwiZXhwIjoxOTg1NTg1ODE0fQ.kZKF_5HedaYHIi4aL77r2PJa5LGeyGlvVnL-tKstycc';
        $storage = new \Supabase\Storage\StorageFile($url, [
            'Authorization' => 'Bearer ' . $service_key,
           ], 'my-new-storage-bucket-public-test');
        
        //$file = file_get_contents('/home/tesillos/Documents/Adolfo/test.txt', true);
        $result = $storage->upload('public/imagen.bmp', 'C:\Users\Adolfo\Documents\imagen.bmp', []);
        fwrite(STDERR, print_r($result, TRUE));

        $this->assertNull($result['error']);
        $this->assertArrayHasKey('data', $result);
    }

    public function testDownload(): void
    {   //Pendiente
        $url = 'https://gpdefvsxamnscceccczu.supabase.co/storage/v1';
        $service_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImdwZGVmdnN4YW1uc2NjZWNjY3p1Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTY3MDAwOTgxNCwiZXhwIjoxOTg1NTg1ODE0fQ.kZKF_5HedaYHIi4aL77r2PJa5LGeyGlvVnL-tKstycc';
        $bucketId = 'my-new-storage-bucket-public-test';
        $storage = new \Supabase\Storage\StorageFile($url, [
            'Authorization' => 'Bearer ' . $service_key,
           ], $bucketId);
        $result = $storage->download('public/image.jpg', []);
        $this->assertNull($result['error']);
        $this->assertArrayHasKey('data', $result);
    }

    public function testUpdate(): void
    {
        $url = 'https://gpdefvsxamnscceccczu.supabase.co/storage/v1';
        $service_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImdwZGVmdnN4YW1uc2NjZWNjY3p1Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTY3MDAwOTgxNCwiZXhwIjoxOTg1NTg1ODE0fQ.kZKF_5HedaYHIi4aL77r2PJa5LGeyGlvVnL-tKstycc';
        $storage = new \Supabase\Storage\StorageFile($url, [
            'Authorization' => 'Bearer ' . $service_key,
           ], 'my-new-storage-bucket-public-test');
        
        //$file = file_get_contents('/home/tesillos/Documents/Adolfo/test.txt', true);
        $result = $storage->update('public/imagen.bmp', 'C:\Users\Adolfo\Documents\imagen.bmp', []);
        $this->assertNull($result['error']);
        $this->assertArrayHasKey('data', $result);
    }

    public function testMove(): void
    {
        $url = 'https://gpdefvsxamnscceccczu.supabase.co/storage/v1';
        $service_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImdwZGVmdnN4YW1uc2NjZWNjY3p1Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTY3MDAwOTgxNCwiZXhwIjoxOTg1NTg1ODE0fQ.kZKF_5HedaYHIi4aL77r2PJa5LGeyGlvVnL-tKstycc';
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
        $url = 'https://gpdefvsxamnscceccczu.supabase.co/storage/v1';
        $service_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImdwZGVmdnN4YW1uc2NjZWNjY3p1Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTY3MDAwOTgxNCwiZXhwIjoxOTg1NTg1ODE0fQ.kZKF_5HedaYHIi4aL77r2PJa5LGeyGlvVnL-tKstycc';
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
        $url = 'https://gpdefvsxamnscceccczu.supabase.co/storage/v1';
        $service_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImdwZGVmdnN4YW1uc2NjZWNjY3p1Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTY3MDAwOTgxNCwiZXhwIjoxOTg1NTg1ODE0fQ.kZKF_5HedaYHIi4aL77r2PJa5LGeyGlvVnL-tKstycc';
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
        $url = 'https://gpdefvsxamnscceccczu.supabase.co/storage/v1';
        $service_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImdwZGVmdnN4YW1uc2NjZWNjY3p1Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTY3MDAwOTgxNCwiZXhwIjoxOTg1NTg1ODE0fQ.kZKF_5HedaYHIi4aL77r2PJa5LGeyGlvVnL-tKstycc';
        $expires = 60;
        $storage = new \Supabase\Storage\StorageFile($url, [
            'Authorization' => 'Bearer ' . $service_key,
           ], 'my-new-storage-bucket-public-test');
        $result = $storage->getPublicUrl('public/imagen.bmp', []);
        $this->assertArrayHasKey('data', $result);
    }
    
}
