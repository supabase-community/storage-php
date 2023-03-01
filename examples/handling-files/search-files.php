<?php

include __DIR__.'/../header.php';
use Supabase\Storage\StorageFile;

$bucket_id = 'test-bucket';

$client = new StorageFile($api_key, $reference_id, $bucket_id);
$options = ['limit'=> 100, 'offset'=> 0, 'sortBy'=> ['column'=> 'name', 'order'=> 'asc',
], 'search'=> 'file-name'];
$result = $client->list('path/to', $options);

$output = json_decode($result->getBody(), true);
print_r($output);
