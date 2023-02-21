<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageFile;

$bucket_id = 'test-bucket';
$client = new StorageFile($bucket_id);
$result = $client->copy('path/to/file.png', 'path/to/file-copy.png');
print_r($result);
