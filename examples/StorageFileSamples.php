<?php

include '../vendor/autoload.php';

use Supabase\Storage\StorageFile;

$authHeader = ['Authorization' => 'Bearer '.'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImdwZGVmdnN4YW1uc2NjZWNjY3p1Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTY3MDAwOTgxNCwiZXhwIjoxOTg1NTg1ODE0fQ.kZKF_5HedaYHIi4aL77r2PJa5LGeyGlvVnL-tKstycc'];
$bucket_id = 'test-bucket';
$client = new  StorageFile(
	'https://'.'gpdefvsxamnscceccczu'.'.supabase.co/storage/v1',
	$authHeader,
	$bucket_id
);

function exampleList(): void
{
	global $client;
	$result = $client->list('path/to');
	print_r($result);
}

/**
 * Example uploads a file to an existing bucket.
 */
function exampleUpload(): void
{
	global $client;
	$options = ['public' => true];
	$result = $client->upload('path/to/file.png', 'https://www.shorturl.at/img/shorturl-icon.png', $options);
	print_r($result);
}

function exampleUpdate(): void
{
	global $client;
	$options = ['transform' => true];
	$result = $client->update('path/to/file.png', 'https://cdn-icons-png.flaticon.com/128/7267/7267612.png', $options);
	print_r($result);
}

function exampleMove(): void
{
	global $client;
	$result = $client->move('path/to/file.png', 'to/new-path/file.png');
	print_r($result);
}

function exampleCopy(): void
{
	global $client;
	$result = $client->copy('path/to/file.png', 'path/to/file-copy.png');
	print_r($result);
}

function exampleCreateSignedUrl(): void
{
	global $client;
	$options = ['public' => true];
	$result = $client->createSignedUrl('path/to/file.png', 60, $options);
	print_r($result);
}

function exampleCreateSignedUrls(): void
{
	global $client;
	$options = ['public' => true];
	$result = $client->createSignedUrls('path/to/file', 60, $options);
	print_r($result);
}

function exampleDownload(): void
{
	global $client;
	$options = ['transform' => true];
	$result = $client->download('path/to/file.png', $options);
	print_r($result);
}

function exampleGetPublicUrl(): void
{
	global $client;
	$options = ['download' => true];
	$result = $client->getPublicUrl('path/to/file.png', $options);
	print_r($result);
}

function exampleRemove(): void
{
	global $client;
	$result = $client->remove('path/to/file-copy.png');
	print_r($result);
}
