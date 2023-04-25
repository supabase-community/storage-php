<?php

include __DIR__.'/../header.php';

use Supabase\Storage\StorageFile;

//Selecting an already created bucket for our test.
$bucket_id = 'test-bucket';
$client = new StorageFile($api_key, $reference_id, $bucket_id);
$result = $client->copy('path/to/file644708bc14e2a.png', 'test-copy', 'path/to/file-copy.png');
$output = json_decode($result->getBody(), true);
print_r($output);
