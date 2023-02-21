<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageClient;
$client = new  StorageClient();
$result = $client->getBucket('test-bucket');
print_r($result);
