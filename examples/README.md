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

 ### **Create a .env  file** 
   ####  Create a file named .env file and paste the template we provided on .env.example, fill out the new file with the enviorment variables needed for the project. We need a .env file to pass enviorment variables securely.

### **Set up your project**
Please reference the documentation to start your project.
#### -  https://supabase.com/docs 



## Running Examples

### example:
> `cd example` 
`php handling-files/list-files.php`

