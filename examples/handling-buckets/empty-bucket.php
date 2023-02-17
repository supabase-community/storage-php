<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageClient;

$api_key = '<your_api_key>';
$supabase_id = '<your_supabase_id>';
$authHeader = ['Authorization' => "Bearer {$api_key}"];
$client = new  StorageClient(
	"https://{$supabase_id}.supabase.co/storage/v1",
	$authHeader
);
$result = $client->emptyBucket('test-bucket');
print_r($result);