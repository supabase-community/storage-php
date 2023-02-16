<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageClient;

$authHeader = ['Authorization' => 'Bearer '.'<your_api_key>'];
$client = new  StorageClient(
	'https://'.'<your_supabase_id>'.'.supabase.co/storage/v1',
	$authHeader
);
$result = $client->updateBucket('test-bucket', ['public' => true]);
print_r($result);
?>