<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageClient;

$client = new  StorageClient();
$result = $client->deleteBucket('test-bucket');
print_r($result);
