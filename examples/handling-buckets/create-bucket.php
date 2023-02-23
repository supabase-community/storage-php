<?php

include realpath('../examples/header.php');
use Supabase\Storage\StorageClient;

$authHeader = ['Authorization' => "Bearer {$api_key}"];
$client = new  StorageClient(
	"https://{$supabase_id}.supabase.co/storage/v1",
	$authHeader
);
$result = $client->createBucket('test-bucket');
print_r($result);
