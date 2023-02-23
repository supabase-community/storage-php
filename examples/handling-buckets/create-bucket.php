<?php

include __DIR__.'/../../vendor/autoload.php';

use Supabase\Storage\StorageClient;
use Dotenv\Dotenv;

$dotenv = Dotenv::createUnsafeImmutable('../../', '.env.test');
$dotenv->load();
$api_key = getenv('API_KEY');
$reference_id = getenv('REFERENCE_ID');

$client = new  StorageClient($api_key, $reference_id);
$result = $client->createBucket('test-bucket-new');
print_r($result);
