<?php

include dirname(__DIR__, 1).'/header.php';
use Supabase\Storage\StorageFile;

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
