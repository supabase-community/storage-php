<?php

include __DIR__.'/../header.php';

use Supabase\Storage\StorageFile;

// Selecting an already created bucket for our test.
$bucket_id = 'test-bucketcket';
// Also creating file with unique ID.
$testFile = 'file'.uniqid().'.png';
// Creating our StorageFile instance to upload files.
$file = new StorageFile($api_key, $reference_id, $bucket_id);
// We will upload a test file to copy it.
$file->upload($testFile, 'https://gpdefvsxamnscceccczu.supabase.co/storage/v1/object/public/examples-bucket/supabase-logo.png', ['public' => false]);
// Print out the list of results.
$result = $file->list('examples-bucketcket', ['limit' => 100, 'offset' => 0, 'sortBy' => [
	'column' => 'name', 'order' => 'asc',
], 'search' => "$testFile"]);
$output = json_decode($result->getBody(), true);
print_r($output);
//delete example files.
$file->remove(["$testFile"]);
