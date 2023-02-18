<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageFile;
use Dotenv\Dotenv;

$dotenv = Dotenv::createUnsafeImmutable('../../');
$dotenv->load();

$api_key = getenv('API_KEY');
$supabase_id = getenv('REFERENCE_ID');
$bucket_id = 'test-bucket';
$authHeader = ['Authorization' => "Bearer {$api_key}"];
$client = new StorageFile(
	"https://{$supabase_id}.supabase.co/storage/v1",
	$authHeader,
	$bucket_id
);

$options = ['transform' => true];
$result = $client->update('path/to/file.png', 'https://cdn-icons-png.flaticon.com/128/7267/7267612.png', $options);
print_r($result);
