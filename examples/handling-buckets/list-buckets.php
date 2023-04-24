<?php

include __DIR__.'/../header.php';
use Supabase\Storage\StorageClient;

$scheme = 'http';
$domain = 'localhost:8000';
$path = '/storage/v1';
$client = new StorageClient($api_key, $reference_id);
$result = $client->listBuckets();
$output = json_decode($result->getBody(), true);
print_r($output);
