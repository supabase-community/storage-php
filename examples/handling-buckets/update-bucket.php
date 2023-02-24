<?php

include __DIR__.'/../header.php';
use Supabase\Storage\StorageClient;

$client = new  StorageClient($api_key, $reference_id);
$result = $client->updateBucket('test-bucket', ['public' => true]);
$output = json_decode($result->getBody(), true);
print_r($output);
