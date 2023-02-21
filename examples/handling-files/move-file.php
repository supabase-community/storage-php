<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageFile;

$bucket_id = 'test-bucket';
$client = new StorageFile($bucket_id);
$result = $client->move('path/to/file.png', 'to/new-path/file.png');
print_r($result);
