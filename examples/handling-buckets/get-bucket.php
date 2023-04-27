<?php

include __DIR__.'/../header.php';

use Supabase\Storage\StorageClient;

//Crete a client.
$client = new StorageClient($api_key, $reference_id);
//Creating a bucket with a unique ID.
$testBucket = 'test-bucket'.uniqid();
$client->createBucket($testBucket, ['public' => false]);
//Method to get a bucket, and print out result.
$result = $client->getBucket($testBucket);
$output = json_decode($result->getBody(), true);
print_r($output);
//Deleting example bucket
$client->deleteBucket($testBucket);
