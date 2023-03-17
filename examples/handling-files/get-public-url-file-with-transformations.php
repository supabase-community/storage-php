<?php

include __DIR__.'/../header.php';
use Supabase\Storage\StorageFile;

$bucket_id = 'test-bucket';

$client = new StorageFile($api_key, $reference_id, $bucket_id);
$options = ['transform' => ['width'=> 50, 'height'=> 50]];
$result = $client->getPublicUrl('path/to/file-base64.png', $options);
print_r($result);
