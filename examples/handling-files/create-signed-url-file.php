<?php

include __DIR__.'/../header.php';

use Supabase\Storage\StorageFile;

$bucket_id = 'test-bucket';

$client = new StorageFile($api_key, $reference_id, $bucket_id);
$options = ['public' => true];
$result = $client->createSignedUrl('path/to/file.png', 60, $options);
print_r($result);

// should be print_r((string) $result->getBody());  and delete the options variable
