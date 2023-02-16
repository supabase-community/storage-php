<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageFile;

$authHeader = ['Authorization' => 'Bearer ' . '<your_api_key>'];
$bucket_id = 'test-bucket';
$client = new StorageFile(
	'https://' . '<your_supabase_id>' . '.supabase.co/storage/v1',
	$authHeader,
	$bucket_id
);

$options = ['public' => true];
$result = $client->upload('path/to/file.png', 'https://www.shorturl.at/img/shorturl-icon.png', $options);
print_r($result);

?>