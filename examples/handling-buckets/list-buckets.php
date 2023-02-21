<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageClient;
$client = new  StorageClient();
$result = $client->listBuckets();

foreach ($result as $bucket) {
	print_r($bucket->name);
}
