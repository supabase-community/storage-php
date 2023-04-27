<?php

include __DIR__.'/../header.php';

use Supabase\Storage\StorageFile;

//Selecting an already created bucket for our test.
$bucket_id = 'test-bucket';
//Also creating file with unique ID.
$testFile = 'file'.uniqid().'.png';
//Creating our StorageFile instance to upload files.
$file = new StorageFile($api_key, $reference_id, $bucket_id);
//We will upload a test file to retrieve the URL.
$file->upload($testFile, 'https://gpdefvsxamnscceccczu.supabase.co/storage/v1/object/public/examples-bucket/supabase-logo.png', ['public' => false]);
//print out the URL of the examples file that will trigger a download.
$result = $file->getPublicUrl($testFile, ['download' => true]);
print_r($result);
//delete example files.  Comment out the file->remove to be able to download the file from the browser.
$file->remove(["$testFile"]);
