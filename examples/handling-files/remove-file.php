<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageFile;

$bucket_id = 'test-bucket';
$client = new StorageFile($bucket_id);
$result = $client->remove('path/to/file-2.png');
print_r($result);
