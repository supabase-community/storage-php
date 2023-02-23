<?php

include dirname(__DIR__, 1).'\vendor\autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$api_key = getenv('API_KEY');
$supabase_id = getenv('REFERENCE_ID');
