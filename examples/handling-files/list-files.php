<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageFile;

$bucket_id = 'test-bucket';
$client = new StorageFile($bucket_id);
$result = $client->list('path/to');
print_r($result);
