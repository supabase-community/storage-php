<?php

include __DIR__.'/../../vendor/autoload.php';

use Supabase\Storage\StorageClient;

$api_key = getenv('API_KEY');
$supabase_id = getenv('REFERENCE_ID');

$authHeader = ['Authorization' => "Bearer {$api_key}"];
$client = new  StorageClient(
	"https://{$supabase_id}.supabase.co/storage/v1",
	$authHeader
);
$result = $client->createBucket('test-bucket');
print_r($result);
