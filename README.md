# storage-php
## Usage
Install the library

`composer require supabase/storage-php`

'TEST'

Import the library

`use Supabase\Storage;`

########################
# `storage-php`

PHP Client library to interact with Supabase Storage.

- Documentation: https://supabase.io/docs/reference/javascript/storage-createbucket

## Quick Start Guide

### Installing the module

```bash
composer require supabase/storage-php
```

### Connecting to the storage backend

```php

use Supabase\Storage;

$url = 'https://<project_ref>.supabase.co/storage/v1';
$service_key = '<service_role>';
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

- Upload a file to an existing bucket:

  ```php
  $file_body = $file; // load your file here
  $opts = $options; //The options for the upload.
  $result = $storage->from('bucket')->upload('path/to/file', $file_body, $opts)
  ```

  > Note:  
  > The path in `data.Key` is prefixed by the bucket ID and is not the value which should be passed to the `download` method in order to fetch the file.  
  > To fetch the file via the `download` method, use `data.path` and `data.bucketId` as follows:
  >
  > ```php
  > const { data, error } = await storageClient.from('bucket').upload('/folder/file.txt', fileBody)
  > // check for errors
  > const { data2, error2 } = await storageClient.from(data.bucketId).download(data.path)
  > ```

  > Note: The `upload` method also accepts a map of optional parameters. For a complete list see the [Supabase API reference](https://supabase.com/docs/reference/javascript/storage-from-upload).

- Download a file from an exisiting bucket:

  ```php
  const { data, error } = await storageClient.from('bucket').download('path/to/file')
  ```

- List all the files within a bucket:

  ```php
  const { data, error } = await storageClient.from('bucket').list('folder')
  ```

  > Note: The `list` method also accepts a map of optional parameters. For a complete list see the [Supabase API reference](https://supabase.com/docs/reference/javascript/storage-from-list).

- Replace an existing file at the specified path with a new one:

  ```php
  $file_body = $file; // load your file here
  $opts = $options; //The options for the upload.
  $result = $storage->from('bucket')->update('path/to/file', $file_body, $opts);
  ```

  > Note: The `upload` method also accepts a map of optional parameters. For a complete list see the [Supabase API reference](https://supabase.com/docs/reference/javascript/storage-from-upload).

- Move an existing file:

  ```php
  $result = $storage->from('bucket')->move('path/to/file', 'new/path/to/file');
  ```

- Delete files within the same bucket:

  ```php
    $result = $storage->from('bucket')->remove('path/to/file');
  ```

- Create signed URL to download file without requiring permissions:

  ```php
    $expire_in = 60;
    $opts = $options; //The options for the download.[ 'download' => TRUE ]
    $result = $storage->from('bucket')->createSignedUrl('path/to/file', $expire_in, $opts);
  ```

- Retrieve URLs for assets in public buckets:

  ```php
    $opts = $options; //The options for the download.[ 'download' => TRUE ]
    $result = $storage->from('public-bucket')->getPublicUrl('path/to/file', $opts);
  ```



