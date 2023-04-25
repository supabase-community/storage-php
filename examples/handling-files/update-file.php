<?php

include __DIR__ . '/../header.php';

use Supabase\Storage\StorageFile;

//Selecting an already created bucket for our test.
$bucket_id = 'test-bucket';
//Also creating file with unique ID.
$testFile = 'file' . uniqid() . '.png';
//Creating our StorageFile instance to upload files.
$file = new StorageFile($api_key, $reference_id, $bucket_id);
//We will upload a test file to update it.
$file->upload($testFile, 'https://www.shorturl.at/img/shorturl-icon.png', ['public' => false]);
//Now we will update the file using the update method.
$result = $file->update($testFile, 'https://cdn-icons-png.flaticon.com/128/7267/7267612.png', ['upsert' => true]);
//print out result.
$output = json_decode($result->getBody(), true);
print_r($output);
//delete example files.
$file->remove(["$testFile"]);
