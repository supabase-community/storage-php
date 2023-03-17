<?php

include __DIR__.'/../header.php';
use Supabase\Storage\StorageFile;

$bucket_id = 'test-bucket';

$client = new StorageFile($api_key, $reference_id, $bucket_id);
$result = $client->remove(['path/to/file-base.png']);
$output = json_decode($result->getBody(), true);
print_r($output);
