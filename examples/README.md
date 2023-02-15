# Supabase `storage-php`

PHP Client library to interact with Supabase Storage.

## Quick Start Sample Guide

### Installing the module

```bash
composer require supabase/storage-php
```

### Connecting to the storage backend

```php
include '../vendor/autoload.php';
use Supabase\Storage\StorageClient;

$authHeader = ['Authorization' => 'Bearer '.'<your_api_key>'];
$bucket_id = 'test-bucket';
$client = new  StorageClient(
	'https://'.'<your_supabase_id>'.'.supabase.co/storage/v1',
	$authHeader
);
```

### Handling resources

#### Handling Storage Buckets

- Sample to create a new Storage bucket:

  ```php
    function createBucket(): void
    {
      global $client;
      $result = $client->createBucket('test-bucket-3');
      print_r($result);
    }
  ```

- Retrieve the details of an existing Storage bucket:

  ```php
    function getBucket(): void
    {
      global $client;
      $result = $client->getBucket('test-bucket');
      print_r($result);
    }
  ```

- Update a new Storage bucket:

  ```php
    function updateBucket(): void
    {
      global $client;
      $result = $client->updateBucket('test-bucket-3', ['public' => true]);
      print_r($result);
    }
  ```

- Remove all objects inside a single bucket:

  ```php
    function emptyBucket(): void
    {
      global $client;
      $result = $client->emptyBucket('test-bucket-2');
      print_r($result);
    }
  ```

- Delete an existing bucket (a bucket can't be deleted with existing objects inside it):

  ```php
    function deleteBucket(): void
    {
      global $client;
      $result = $client->deleteBucket('test-bucket-3');
      print_r($result);
    }
  ```

- Retrieve the details of all Storage buckets within an existing project:

  ```php
    function listBuckets(): void
    {
      global $client;
      $result = $client->listBuckets();
      print_r($result);
      foreach ($result as $bucket) {
        print_r($bucket->name);
      }
    }
  ```

#### Handling Files

### Connecting to the storage backend

```php
  include '../vendor/autoload.php';

  use Supabase\Storage\StorageFile;

  $authHeader = ['Authorization' => 'Bearer '.'<your_api_key>'];
  $bucket_id = 'test-bucket';
  $client = new  StorageFile(
    'https://'.'<your_supabase_id>'.'.supabase.co/storage/v1',
    $authHeader,
    $bucket_id
  );
```

- Upload a file to an existing bucket:

  ```php
    function exampleUpload(): void
    {
      global $client;
      $options = ['public' => true];
      $result = $client->upload('path/to/file.png', 'https://www.shorturl.at/img/shorturl-icon.png', $options);
      print_r($result);
    }
  ```

- Download a file from an exisiting bucket:

  ```php
    function exampleDownload(): void
    {
      global $client;
      $options = ['transform' => true];
      $result = $client->download('path/to/file.png', $options);
      print_r($result);
    }
  ```

- List all the files within a bucket:

  ```php
    function exampleList(): void
    {
      global $client;
      $result = $client->list('path/to');
      print_r($result);
    }
  ```

- Replace an existing file at the specified path with a new one:

  ```php
    function exampleUpdate(): void
    {
      global $client;
      $options = ['transform' => true];
      $result = $client->update('path/to/file.png', 'https://cdn-icons-png.flaticon.com/128/7267/7267612.png', $options);
      print_r($result);
    }
  ```

- Move an existing file:

  ```php
    function exampleMove(): void
    {
      global $client;
      $result = $client->move('path/to/file.png', 'to/new-path/file.png');
      print_r($result);
    }
  ```

- Delete files within the same bucket:

  ```php
    function exampleRemove(): void
    {
      global $client;
      $result = $client->remove('path/to/file-copy.png');
      print_r($result);
    }
  ```

- Create signed URL to download file without requiring permissions:

  ```php
    function exampleCreateSignedUrl(): void
    {
      global $client;
      $options = ['public' => true];
      $result = $client->createSignedUrl('path/to/file.png', 60, $options);
      print_r($result);
    }
  ```

- Retrieve URLs for assets in public buckets:

  ```php
    function exampleGetPublicUrl(): void
    {
      global $client;
      $options = ['download' => true];
      $result = $client->getPublicUrl('path/to/file.png', $options);
      print_r($result);
    }
  ```

- To get the error messages you can do it in the following way:

  ```php
    function exampleGetPublicUrl(): void
    {
      global $client;
      $options = ['download' => true];
      $result = $client->getPublicUrl('path/to/file.png', $options);
      print_r($result->getMessage());
    }
  ```

- You can test these functions using the command line:
```
$ php -r "require 'StorageBucketSamples.php'; createBucket();"
```



