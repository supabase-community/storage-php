# Supabase `storage-php`

PHP Client library to interact with Supabase Storage.

> **Note:** This repository is in Alpha and is not ready for production usage. API's will change as it progresses to initial release.

## Quick Start Guide

### Installing the module

```bash
composer require supabase/storage-php
```

### Connecting to the storage backend

```php

use Supabase\Storage;

$url = 'https://'.$project_ref.'supabase.co/storage/v1';
$service_key = $service_role;
$storage = new Storage\StorageClient($url, [
 'Authorization' => 'Bearer ' . $service_key,
]);
```

### Handling resources

#### Handling Storage Buckets

- Create a new Storage bucket:

  ```php
    $opts = [ 'public' => true ]; //Bucket options
    $result = $storage->createBucket('my-new-storage-bucket', $opts);
  ```

- Retrieve the details of an existing Storage bucket:

  ```php
  $result = $storage->getBucket('test_bucket');
  ```

- Update a new Storage bucket:

  ```php
   $opts = [ 'public' => true ]; //Bucket options.
   $result = $storage->updateBucket('test_bucket' /* Bucket name */,
    $opts);
  ```

- Remove all objects inside a single bucket:

  ```php
  $result = $storage->emptyBucket('test_bucket');
  ```

- Delete an existing bucket (a bucket can't be deleted with existing objects inside it):

  ```php
  $result = $storage->deleteBucket('test_bucket');
  ```

- Retrieve the details of all Storage buckets within an existing project:

  ```php
  $result = $storage->listBuckets();
  ```

#### Handling Files

### Connecting to the storage backend

```php

use Supabase\Storage\StorageFile;

$url = 'https://<project_ref>.supabase.co/storage/v1';
$service_key = '<service_role>';
$bucket_id = '<storage-bucket-id';
$storage = new StorageFile($url, [
 'Authorization' => 'Bearer ' . $service_key,
], $bucket_id);
```

- Upload a file to an existing bucket:

  ```php
  $file_path = $path; // where to uploaded [folder with file name]
  $file_body = $file; // load your file here
  $opts = $options; //The options for the upload.
  $result = $storage->upload($file_path, $file_body, $options);
  ```

- Download a file from an exisiting bucket:

  ```php
  $file_path = $path; // path to file
  $opts = $options; //The options for the download.
  $result = $storage->download($file_path, $options);
  ```

- List all the files within a bucket:

  ```php
  $path = $path_bucket; // path to files
  $result = $storage->list($path);
  ```

  > Note: The `list` method also accepts a map of optional parameters. For a complete list see the [Supabase API reference](https://supabase.com/docs/reference/javascript/storage-from-list).

- Replace an existing file at the specified path with a new one:

  ```php
  $path = 'path/to/file';
  $file_body = $file; // load your file here
  $opts = $options; //The options for the upload.
  $result = $storage->update($path, $file_body, $opts);
  ```

  > Note: The `upload` method also accepts a map of optional parameters. For a complete list see the [Supabase API reference](https://supabase.com/docs/reference/javascript/storage-from-upload).

- Move an existing file:

  ```php
  $path = 'path/to/file';
  $new_path = 'new/path/to/file';
  $result = $storage->move($path, $new_path);
  ```

- Delete files within the same bucket:

  ```php
  $path = 'path/to/file';
  $result = $storage->remove($path);
  ```

- Create signed URL to download file without requiring permissions:

  ```php
    $path = 'path/to/file';
    $expire_in = 60;
    $opts = $options; //The options for the download.[ 'download' => TRUE ]
    $storage->createSignedUrl($path, $expire_in, $opts);
  ```

- Retrieve URLs for assets in public buckets:

  ```php
    $path = 'path/to/file';
    $opts = $options; //The options for the download.[ 'download' => TRUE ]
    $storage->testGetPublicUrl($path, $opts);
  ```



