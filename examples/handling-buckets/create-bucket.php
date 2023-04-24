<?php

include __DIR__.'/../header.php';
use Supabase\Storage\StorageClient;

$scheme = 'http';
$domain = 'localhost:3000';
$path = '/storage/v1';
$client = new StorageClient($api_key, $reference_id, $domain, $scheme, $path);
$result = $client->createBucket('test-bucket-new', ['public' => false]);
$output = json_decode($result->getBody(), true);

print_r($output);
