<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageFile;

$api_key = '<your_api_key>';
$supabase_id = '<your_supabase_id>';
$bucket_id = 'test-bucket';
$authHeader = ['Authorization' => "Bearer {$api_key}"];
$client = new StorageFile(
	"https://{$supabase_id}.supabase.co/storage/v1",
	$authHeader,
	$bucket_id
);

$options = ['public' => true];
$result = $client->createSignedUrl('path/to/file.png', 60, $options);
print_r($result);
