<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageFile;

$bucket_id = 'test-bucket';
$client = new StorageFile($bucket_id);
$options = ['public' => true];
$result = $client->createSignedUrl('path/to/file.png', 60, $options);
print_r($result);
