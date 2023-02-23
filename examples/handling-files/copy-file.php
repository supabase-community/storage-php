<?php

include dirname(__DIR__, 1).'\header.php';
use Supabase\Storage\StorageFile;

$bucket_id = 'test-bucket';
$authHeader = ['Authorization' => "Bearer {$api_key}"];
$client = new StorageFile(
	"https://{$supabase_id}.supabase.co/storage/v1",
	$authHeader,
	$bucket_id
);
$result = $client->copy('path/to/file.png', 'path/to/file-copy.png');
print_r($result);
