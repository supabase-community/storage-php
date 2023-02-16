# Supabase `storage-php` samples

PHP Client library samples to interact with Supabase Storage.

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
  $result = $client->createBucket('test-bucket-3');
  print_r($result);
  ```

- Retrieve the details of an existing Storage bucket:

  ```php
  $result = $client->getBucket('test-bucket');
  print_r($result);
  ```

- Update a new Storage bucket:

  ```php
  $result = $client->updateBucket('test-bucket-3', ['public' => true]);
  print_r($result);
  ```

- Remove all objects inside a single bucket:

  ```php
  $result = $client->emptyBucket('test-bucket-2');
  print_r($result);
  ```

- Delete an existing bucket (a bucket can't be deleted with existing objects inside it):

  ```php
  $result = $client->deleteBucket('test-bucket-3');
  print_r($result);
  ```

- Retrieve the details of all Storage buckets within an existing project:

  ```php
  $result = $client->listBuckets();
  print_r($result);
  foreach ($result as $bucket) {
    print_r($bucket->name);
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
  $options = ['public' => true];
  $result = $client->upload('path/to/file.png', 'https://www.shorturl.at/img/shorturl-icon.png', $options);
  ```

- Download a file from an exisiting bucket:

  ```php
  $options = ['transform' => true];
  $result = $client->download('path/to/file.png', $options);
  print_r($result);
  ```

- List all the files within a bucket:

  ```php
  $result = $client->list('path/to');
  print_r($result);
  ```

- Replace an existing file at the specified path with a new one:

  ```php
  $options = ['transform' => true];
  $result = $client->update('path/to/file.png', 'https://cdn-icons-png.flaticon.com/128/7267/7267612.png', $options);
  print_r($result);
  ```

- Move an existing file:

  ```php
  $result = $client->move('path/to/file.png', 'to/new-path/file.png');
  print_r($result);
  ```

- Delete files within the same bucket:

  ```php
  $result = $client->remove('path/to/file-copy.png');
  print_r($result);
  ```

- Create signed URL to download file without requiring permissions:

  ```php
  $options = ['public' => true];
  $result = $client->createSignedUrl('path/to/file.png', 60, $options);
  print_r($result);
  ```

- Retrieve URLs for assets in public buckets:

  ```php
  $options = ['download' => true];
  $result = $client->getPublicUrl('path/to/file.png', $options);
  print_r($result);
  ```

- To get the error messages you can do it in the following way:

  ```php
  $options = ['download' => true];
  $result = $client->getPublicUrl('path/to/file.png', $options);
  print_r($result->getMessage());
  ```

- You can test these code using the command line:
```
$ php download-file.php"
```



