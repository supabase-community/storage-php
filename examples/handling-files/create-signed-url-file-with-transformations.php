<?php

include __DIR__.'/../header.php';
use Supabase\Storage\StorageFile;

$bucket_id = 'test-bucket';

$client = new StorageFile($api_key, $reference_id, $bucket_id);
$options = ['transform' => ['width'=> '100', 'height'=> '100']];
$result = $client->createSignedUrl('path/to/file-base64.png', 60, $options);
print_r($result);
