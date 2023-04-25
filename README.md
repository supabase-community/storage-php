# Supabase `storage-php`

PHP Client library to interact with Supabase Storage.

> **Note:** This repository is in Alpha and is not ready for production usage. API's will change as it progresses to initial release.


### TODO

- [ ] Support for PHP 7.4 
- [ ] Running unit and integration tests together results in test failures 


## Quick Start Guide

### Installing the module

```bash
composer require supabase/storage-php
```

### Connecting to the storage backend

```php

use Supabase\Storage;

include __DIR__.'/vendor/autoload.php';

use Supabase\Storage;

$client = new StorageClient('API_KEY', 'REFERENCE_ID');
```

### Examples

@TODO - point to the examples directory

### Testing

Setup the testing Env

```
cp .env.example tests/.env
```

#### For the `REFERENCE_ID`
Once signed on to the dashboard, navigate to, Project >> Project Settings >> General settings. Copy the Reference ID for use in the `.env`.

#### For the `API_KEY`
Once signed on to the dashboard, navigate to, Project >> Project Settings >> API >> Project API keys. Choose either the `anon` `public` or the `service_role` key.

Populate the `tests/.env` to include `REFERENCE_ID` and `API_KEY`.

#### Running all tests

```
vendor/bin/phpunit
```
