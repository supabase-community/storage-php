# Supabase `storage-php` examples 

Examples of how to interact with the `storage-php` library.

```
.
├── handling-buckets
│   ├── create-bucket.php
│   ├── delete-bucket.php
│   ├── empty-bucket.php
│   ├── get-bucket.php
│   ├── list-buckets.php
│   └── update-bucket.php
└── handling-files
    ├── copy-file.php
    ├── create-signed-url-file.php
    ├── download-file.php
    ├── get-public-url-file.php
    ├── list-files.php
    ├── move-file.php
    ├── remove-file.php
    ├── update-file.php
    └── upload-file.php
```

## Setup
Clone the repository locally.

Install the dependencies `composer install` 

### API Access Details
To obtain the API Access Details, please sign into your Supabase account. 

#### For the `PROJECT_REF`
Once signed on to the dashboard, navigate to, Project >> Project Settings >> General settings. Copy the Reference ID for use in the `.env`.

#### For the `API_KEY`
Once signed on to the dashboard, navigate to, Project >> Project Settings >> API >> Project API keys. Choose either the `anon` `public` or the `service_role` key.

### Setup the Env

```
cd examples
cp .env.example .env
```

Populate the `.env` to include `REFERENCE_ID` and `API_KEY`.

## Running Examples

```
cd examples
php handling-files/list-files.php
```
