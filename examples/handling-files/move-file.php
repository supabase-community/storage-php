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

$result = $client->move('path/to/file.png', 'to/new-path/file.png');
print_r($result);
//echo realpath(dirname(__FILE__));
echo realpath('../vendor/autoload.php');
