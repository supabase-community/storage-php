<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

// TODO: Make StorageClient init with supplied secrets.
// i.e. StorageClient('https://abc.supabase.co/storage/v1', ['Authorization' => 'Bearer ' . 'SECRET])

final class StorageBucketTest extends TestCase
{

    private $client;

    public function setup(): void {
        $authHeader = ['Authorization' => 'Bearer ' . 'SECRET'];
        $this->client = new \Supabase\SupabaseClient('https://abc.supabase.co'),
    }

    public function testListBucket(): void
    {
        $result =  $this->client->listBuckets();

        $this->assertGreaterThan(0, count($result['data']));
    }

    public function testGetBucketWithId(): void
    {
        $result = $this->client->getBucket('test');

        $this->assertArrayHasKey('data', $result);
        $this->assertNull($result['error']);
    }

    public function testGetBucketWithInvalidId(): void
    {
        $result = $this->client->getBucket('not-a-real-bucket-id');

        $this->assertArrayHasKey('error', $result);
        $this->assertNull($result['data']);
    }

    public function testCreateBucket(): void
    {
        $result = $this->client->createBucket('my-new-storage-bucket');
        $this->assertNull($result['error']);
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals($result['data']['id'], 'my-new-storage-bucket');
    }

    public function testCreatePublicBucket(): void
    {
        $result = $this->client->createBucket('my-new-storage-bucket-public', ['public' => true]);
        $this->assertNull($result['error']);
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals($result['data'], 'my-new-storage-bucket-public');
    }

    public function testUpdateBucket(): void
    {
        $result = $this->client->updateBucket('my-new-storage-bucket-public', ['public' => false]);
        $this->assertNull($result['error']);
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals($result['data'], 'my-new-storage-bucket-public');
    }

    public function testEmptyBucket()
    {
        $result = $this->client->emptyBucket('my-new-storage-bucket-public');
        $this->assertNull($result['error']);
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals($result['data'], 'my-new-storage-bucket-public');
    }

    public function testDeleteBucket()
    {
        $result = $this->client->deleteBucket('my-new-storage-bucket-public');
        $this->assertNull($result['error']);
    }
}
