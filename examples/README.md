# Supabase `storage-php` examples 

These examples will provide a way to interact with the `storage-php` library.

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

### **Downloading the package**
Download the package supabase/storage-php. On your terminal run `composer require supabase/storage-php` 

### **API Keys**
To get your API keys, please sign into your Supabase account. 
Once signed on your dashboard, go to, Project >> Project Settings >> API Settings >> Project API keys
 #### *You can use the keys to use Supabase client libraries.*

####  **NOTE: Never share your secret key in public, this key has the ablity to bypass Row level security.**

### ** Set up your project**
Please reference the documentation to start your project.
#### -  https://supabase.com/docs 



## Running Examples

### This section is for testing the examples, first open your terminal and go to the desired file to test 

Remember to set up your sensitove information on a .env file. 

### example:
> `cd example`
> `cd handling-files`
> `php list-files.php`



```
API_KEY="<your_api_key>" REFERENCE_ID="<your_reference_id>"; php handling-buckets/create-bucket.php
```

