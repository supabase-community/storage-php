<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class StorageBucketTest extends TestCase
{
    public function testListBucket(): void
    {
        $storage = new \Supabase\Storage\StorageClient('https://gpdefvsxamnscceccczu.supabase.co/storage/v1', ['Authorization' => 'Bearer ' . 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImdwZGVmdnN4YW1uc2NjZWNjY3p1Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTY3MDAwOTgxNCwiZXhwIjoxOTg1NTg1ODE0fQ.kZKF_5HedaYHIi4aL77r2PJa5LGeyGlvVnL-tKstycc']);

        $result = $storage->listBuckets();

        $this->assertGreaterThan(0, count($result['data']));
    }

    public function testGetBucketWithId(): void
    {
        $storage = new \Supabase\Storage\StorageClient('https://gpdefvsxamnscceccczu.supabase.co/storage/v1', ['Authorization' => 'Bearer ' . 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImdwZGVmdnN4YW1uc2NjZWNjY3p1Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTY3MDAwOTgxNCwiZXhwIjoxOTg1NTg1ODE0fQ.kZKF_5HedaYHIi4aL77r2PJa5LGeyGlvVnL-tKstycc']);

        $result = $storage->getBucket('test');

        $this->assertArrayHasKey('data', $result);
        $this->assertNull($result['error']);
    }

    public function testGetBucketWithInvalidId(): void
    {
        $storage = new \Supabase\Storage\StorageClient('https://gpdefvsxamnscceccczu.supabase.co/storage/v1', ['Authorization' => 'Bearer ' . 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImdwZGVmdnN4YW1uc2NjZWNjY3p1Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTY3MDAwOTgxNCwiZXhwIjoxOTg1NTg1ODE0fQ.kZKF_5HedaYHIi4aL77r2PJa5LGeyGlvVnL-tKstycc']);

        $result = $storage->getBucket('not-a-real-bucket-id');

        $this->assertArrayHasKey('error', $result);
        $this->assertNull($result['data']);
    }

    public function testCreateBucket(): void
    {
        $storage = new \Supabase\Storage\StorageClient('https://gpdefvsxamnscceccczu.supabase.co/storage/v1', ['Authorization' => 'Bearer ' . 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImdwZGVmdnN4YW1uc2NjZWNjY3p1Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTY3MDAwOTgxNCwiZXhwIjoxOTg1NTg1ODE0fQ.kZKF_5HedaYHIi4aL77r2PJa5LGeyGlvVnL-tKstycc']);

        $result = $storage->createBucket('my-new-storage-bucket');
        $this->assertNull($result['error']);
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals($result['data']['id'], 'my-new-storage-bucket');
    }

    public function testCreatePublicBucket(): void
    {

        $storage = new \Supabase\Storage\StorageClient('https://gpdefvsxamnscceccczu.supabase.co/storage/v1', ['Authorization' => 'Bearer ' . 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImdwZGVmdnN4YW1uc2NjZWNjY3p1Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTY3MDAwOTgxNCwiZXhwIjoxOTg1NTg1ODE0fQ.kZKF_5HedaYHIi4aL77r2PJa5LGeyGlvVnL-tKstycc']);

        $result = $storage->createBucket('my-new-storage-bucket-public', ['public' => true]);
        $this->assertNull($result['error']);
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals($result['data'], 'my-new-storage-bucket-public');
    }

    public function testUpdateBucket(): void
    {

        $storage = new \Supabase\Storage\StorageClient('https://gpdefvsxamnscceccczu.supabase.co/storage/v1', ['Authorization' => 'Bearer ' . 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImdwZGVmdnN4YW1uc2NjZWNjY3p1Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTY3MDAwOTgxNCwiZXhwIjoxOTg1NTg1ODE0fQ.kZKF_5HedaYHIi4aL77r2PJa5LGeyGlvVnL-tKstycc']);

        $result = $storage->updateBucket('my-new-storage-bucket-public', ['public' => false]);
        $this->assertNull($result['error']);
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals($result['data'], 'my-new-storage-bucket-public');
    }

    public function testEmptyBucket()
    {

        $storage = new \Supabase\Storage\StorageClient('https://gpdefvsxamnscceccczu.supabase.co/storage/v1', ['Authorization' => 'Bearer ' . 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImdwZGVmdnN4YW1uc2NjZWNjY3p1Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTY3MDAwOTgxNCwiZXhwIjoxOTg1NTg1ODE0fQ.kZKF_5HedaYHIi4aL77r2PJa5LGeyGlvVnL-tKstycc']);

        $result = $storage->emptyBucket('my-new-storage-bucket-public');
        $this->assertNull($result['error']);
        $this->assertArrayHasKey('data', $result);
        echo var_dump($result['data']);
        $this->assertEquals($result['data'], 'my-new-storage-bucket-public');
    }

    public function testDeleteBucket()
    {
        $storage = new \Supabase\Storage\StorageClient('https://gpdefvsxamnscceccczu.supabase.co/storage/v1', ['Authorization' => 'Bearer ' . 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImdwZGVmdnN4YW1uc2NjZWNjY3p1Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTY3MDAwOTgxNCwiZXhwIjoxOTg1NTg1ODE0fQ.kZKF_5HedaYHIi4aL77r2PJa5LGeyGlvVnL-tKstycc']);

        $result = $storage->deleteBucket('my-new-storage-bucket-public');

        $this->assertNull($result['error']);
    }
}
