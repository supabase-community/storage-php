<?php

include '../../vendor/autoload.php';

use Dotenv\Dotenv;
use Supabase\Storage\StorageFile;

$dotenv = Dotenv::createUnsafeImmutable('../../', '.env.test');
$dotenv->load();
$api_key = getenv('API_KEY');
$reference_id = getenv('REFERENCE_ID');

$bucket_id = 'test-bucket';
$client = new StorageFile($api_key, $reference_id, $bucket_id);
$result = $client->list('path/to');

//first way to manipulate the  return
$body = $result->getBody();
$content = $body->getContents();
print_r($content);

//second way to manipulate the  return
print_r(json_decode($result->getBody(), true));
