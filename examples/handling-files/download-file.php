<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageFile;

$bucket_id = 'test-bucket';
$client = new StorageFile($bucket_id);
$options = ['transform' => true];
$result = $client->download('path/to/file.png', $options);
print_r($result);
