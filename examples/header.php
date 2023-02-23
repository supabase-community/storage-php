<?php

include realpath(dirname(__DIR__).'../vendor/autoload.php');

use Dotenv\Dotenv;

$dotenv = Dotenv::createUnsafeImmutable(realpath('../examples'));
$dotenv->load();

$api_key = getenv('API_KEY');
$supabase_id = getenv('REFERENCE_ID');
