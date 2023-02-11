<?php
include('../vendor/autoload.php');

use Supabase\Storage\StorageFile;

$authHeader = ['Authorization' => 'Bearer ' . '<your_api_key>'];
$bucket_id = 'test-bucket';
$client = new  StorageFile(
	'https://' . '<your_supabase_id>' . '.supabase.co/storage/v1',
	$authHeader,
	$bucket_id
);

/**
 * Example uploads a file to an existing bucket.
 *
 */
function exampleUpload(): void
{
	global $client;
	$options = ['public' => true];
	$result = $client->upload('path/to/file', 'https://your-file-body/file', $options);
	print_r($result);
}

function exampleDownload(): void
{
	global $client;
	$options = ['transform' => true];
	$result = $client->download('path/to/file', $options);
	print_r($result);
}

function exampleUpdate(): void
{
	global $client;
	$options = ['transform' => true];
	$result = $client->update('path/to/file', 'https://your-file-body/new-file', $options);
	print_r($result);
}
