<?php

include __DIR__.'/../header.php';

use Supabase\Storage\StorageClient;

//giving unique id to our bucket
$testBucket = 'test-bucket'.uniqid();

//creating our client and passing API_KEY & REFERENCE_ID
$client = new StorageClient($api_key, $reference_id);

//Created a bucket and printing out thr result
$result = $client->createBucket($testBucket, ['public' => false]);
$output = json_decode($result->getBody(), true);
print_r($output);

//Deleting our examples
$client->deleteBucket($testBucket);
