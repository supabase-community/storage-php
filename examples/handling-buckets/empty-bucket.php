<?php

include __DIR__.'/../header.php';

use Supabase\Storage\StorageClient;

//Creating out client to upload files
$client = new  StorageClient($api_key, $reference_id);
//Assigning a unique ID to our bucket
$testBucket = 'test-bucket'.uniqid();
//creating a bucket to upload files into
$client->createBucket($testBucket, ['public' => false]);
//We will empty out our bucket with the following function and print our the response.
$result = $client->emptyBucket($testBucket);
$output = json_decode($result->getBody(), true);
print_r($output);

//Delete the example bucket
$client->deleteBucket($testBucket);
