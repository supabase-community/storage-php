<?php

include __DIR__.'/../header.php';

use Supabase\Storage\StorageFile;

//Selecting an already created bucket for our test.
$bucket_id = 'test-bucket';
//Also creating file with unique ID.
$testFile = 'file'.uniqid().'.png';
//Creating our StorageFile instance to upload files.
$file = new StorageFile($api_key, $reference_id, $bucket_id);
//We will upload a test file.
$file->upload($testFile, 'https://gpdefvsxamnscceccczu.supabase.co/storage/v1/object/public/examples-bucket/supabase-logo.png', ['public' => false]);
//print out result and download the file to our directory.
$result = $file->download($testFile, ['transform' => ['width' => 50, 'height' => 50]]);
$output = $result->getBody()->getContents();
file_put_contents('file.png', $output);
//delete example files.
$file->remove(["$testFile"]);
