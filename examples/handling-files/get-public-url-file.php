<?php

include realpath('../examples/header.php');
use Supabase\Storage\StorageFile;

$bucket_id = 'test-bucket';
$authHeader = ['Authorization' => "Bearer {$api_key}"];
$client = new StorageFile(
	"https://{$supabase_id}.supabase.co/storage/v1",
	$authHeader,
	$bucket_id
);

$options = ['download' => true];
$result = $client->getPublicUrl('path/to/file.png', $options);
print_r($result);
