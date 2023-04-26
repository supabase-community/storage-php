<?php

include __DIR__.'/../header.php';

use Supabase\Storage\StorageClient;

//Creating unique ID
$testBucket = 'test-bucket'.uniqid();

//Creating our client and passing API_KEY & REFERENCE_ID
$client = new  StorageClient($api_key, $reference_id);
//Creating a bucket as example to test our remove method.
$client->createBucket($testBucket, ['public' => false]);

//Deleting a bucket function and printing result.
$result = $client->deleteBucket($testBucket);
$output = json_decode($result->getBody(), true);
print_r($output);
