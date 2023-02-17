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

$options = ['public' => false];
$result = $client->upload('path/to/file.png', 'https://www.shorturl.at/img/shorturl-icon.png', $options);
print_r($result);
?>