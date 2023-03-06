<?php

include __DIR__.'/../header.php';
use Supabase\Storage\StorageFile;

$bucket_id = 'test-bucket';

$client = new StorageFile($api_key, $reference_id, $bucket_id);

$options = ['contentType' => 'image/png'];
// Get the image and convert into string
$img = file_get_contents(
	'https://images.squarespace-cdn.com/content/v1/6351e8dab3ca291bb37a18fb/c097a247-cbdf-4e92-a5bf-6b52573df920/1666314646844.png');
$data = base64_encode($img);
$result = $client->upload('path/to/file-base64.png', $data, $options);
$output = json_decode($result->getBody(), true);
print_r($output);
