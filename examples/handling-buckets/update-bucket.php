<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageClient;

$client = new  StorageClient();
$result = $client->updateBucket('test-bucket', ['public' => true]);
print_r($result);
