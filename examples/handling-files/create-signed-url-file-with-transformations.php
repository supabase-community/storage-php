<?php

include __DIR__.'/../header.php';

use Supabase\Storage\StorageFile;

//Selecting an already created bucket for our test.
$bucket_id = 'test-bucket';
//Creating file with unique ID.
$testFile = 'file'.uniqid().'.png';
//Creating our StorageFile instance to upload files.
$file = new StorageFile($api_key, $reference_id, $bucket_id);
//We will upload a test file to retrieve the URL.
$file->upload($testFile, 'https://gpdefvsxamnscceccczu.supabase.co/storage/v1/object/public/examples-bucket/supabase-logo.png', ['public' => false]);
//print out the URL of the examples file.
$options = ['transform' => ['width' => '100', 'height' => '100']];
$result = $file->createSignedUrl($testFile, 60, $options);
print_r($result->getBody()->getContents());
//delete example files.
$file->remove(["$testFile"]);
