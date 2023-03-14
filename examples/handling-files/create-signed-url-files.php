<?php

include __DIR__.'/../header.php';

use Supabase\Storage\StorageFile;

$bucket_id = 'test-bucket';

$client = new StorageFile($api_key, $reference_id, $bucket_id);
$options = ['public' => true];
$result = $client->createSignedUrls(['test-file.jpg', 'path/to/file-base64.png'], 60, $options);
print_r($result);
