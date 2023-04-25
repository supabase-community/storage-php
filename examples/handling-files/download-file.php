<?php

include __DIR__ . '/../header.php';

use Supabase\Storage\StorageFile;

$bucket_id = 'test-bucket';

$client = new StorageFile($api_key, $reference_id, $bucket_id);
$result = $client->download('testFile-644764320fed8.png');
$output = $result->getBody()->getContents();
file_put_contents('file.png', $output);
