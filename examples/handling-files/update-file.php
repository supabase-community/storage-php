<?php

include __DIR__.'/../header.php';
use Supabase\Storage\StorageFile;

$bucket_id = 'test-bucket';

$client = new StorageFile($api_key, $reference_id, $bucket_id);

$options = ['upsert' => true];
$result = $client->update('path/to/file.png', 'https://cdn-icons-png.flaticon.com/128/7267/7267612.png', $options);
$output = json_decode($result->getBody(), true);
print_r($output);
