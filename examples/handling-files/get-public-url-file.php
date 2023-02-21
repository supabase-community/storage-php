<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageFile;

$bucket_id = 'test-bucket';
$client = new StorageFile($bucket_id);
$options = ['download' => true];
$result = $client->getPublicUrl('path/to/file.png', $options);
print_r($result);
