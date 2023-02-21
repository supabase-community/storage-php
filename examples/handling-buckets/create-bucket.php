<?php

include __DIR__.'/../../vendor/autoload.php';

use Supabase\Storage\StorageClient;

$client = new  StorageClient();
$result = $client->createBucket('test-bucket-new');
print_r($result);
