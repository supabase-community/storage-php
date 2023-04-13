# Supabase `storage-php`

PHP Client library to interact with Supabase Storage.

> **Note:** This repository is in Alpha and is not ready for production usage. API's will change as it progresses to initial release.

## Quick Start Guide

### Installing the module

```bash
composer require supabase/storage-php
```
> **Note:** Rename the .env.example file to .env and modify your credentials REFERENCE_ID and API_KEY.

### Connecting to the storage backend

```php

use Supabase\Storage;

$api_key = getenv('API_KEY');
$reference_id = getenv('REFERENCE_ID');
$client = new StorageClient($api_key, $reference_id);
```

### Examples

@TODO - point to the examples directory

### Testing


@TODO - point to the examples directory

