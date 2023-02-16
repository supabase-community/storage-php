<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageClient;

$authHeader = ['Authorization' => 'Bearer ' . '<your_api_key>'];
$bucket_id = 'test-bucket';
$client = new StorageClient(
	'https://' . '<your_supabase_id>' . '.supabase.co/storage/v1',
	$authHeader
);
$result = $client->listBuckets();
print_r($result);
foreach ($result as $bucket) {
	print_r($bucket->name);
}
?>