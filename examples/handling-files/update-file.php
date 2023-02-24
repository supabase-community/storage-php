<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageFile;
use Dotenv\Dotenv;

$dotenv = Dotenv::createUnsafeImmutable('../../', '.env.test');
$dotenv->load();
$api_key = getenv('API_KEY');
$reference_id = getenv('REFERENCE_ID');

$bucket_id = 'test-bucket';
$client = new StorageFile($api_key, $reference_id, $bucket_id);

$options = ['transform' => true];
$result = $client->update('path/to/file.png', 'https://cdn-icons-png.flaticon.com/128/7267/7267612.png', $options);
$output = json_decode($result->getBody(), true);
print_r($output);
