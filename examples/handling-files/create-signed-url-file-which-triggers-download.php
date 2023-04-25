<?php

include __DIR__.'/../header.php';

use Supabase\Storage\StorageFile;

$bucket_id = 'test-bucket';

//Also creating file with unique ID.
$testFile = 'file'.uniqid();
//Creating our StorageFile instance to upload files.
$file = new StorageFile($api_key, $reference_id, $bucket_id);
//We will upload a test file to retrieve the URL.
$file->upload($testFile, 'https://www.shorturl.at/img/shorturl-icon.png', ['public' => false]);
//print out the URL of the examples file.
$options = ['download' => true];
$result = $file->createSignedUrl($testFile, 60, $options);
print_r($result->getBody()->getContents());
//delete example files.
$file->remove(["$testFile"]);
