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

$options = ['transform' => true];
$result = $client->update('path/to/file.png', 'https://cdn-icons-png.flaticon.com/128/7267/7267612.png', $options);
print_r($result);

?>