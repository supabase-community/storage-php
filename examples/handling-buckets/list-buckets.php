<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageClient;
use Dotenv\Dotenv;

$dotenv = Dotenv::createUnsafeImmutable('../../', '.env.test');
$dotenv->load();
$api_key = getenv('API_KEY');
$reference_id = getenv('REFERENCE_ID');
$client = new  StorageClient($api_key, $reference_id);
$result = $client->listBuckets();
$output = json_decode($result->getBody(), true);
print_r($output);
