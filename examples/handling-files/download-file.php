<?php

include __DIR__.'/../header.php';
use Supabase\Storage\StorageFile;

$bucket_id = 'test-bucket';

$client = new StorageFile($api_key, $reference_id, $bucket_id);
$options = ['transform' => true];
$result = $client->download('path/to/file.png', $options);
$output = $result->getBody()->getContents();
file_put_contents('file.png', $output);
print_r($output);
