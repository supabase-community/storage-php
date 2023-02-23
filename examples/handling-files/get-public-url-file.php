<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageFile;
use Dotenv\Dotenv;

$dotenv = Dotenv::createUnsafeImmutable('../../', '.env.test');
$dotenv->load();
$api_key = getenv('API_KEY');
$reference_id = getenv('REFERENCE_ID');

$bucket_id = 'test-bucket';
$client = new StorageFile($api_key, $reference_id, $bucket_id);
$options = ['download' => true];
$result = $client->getPublicUrl('path/to/file.png', $options);
print_r($result);
