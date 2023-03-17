<?php

include __DIR__.'/../vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$api_key = getenv('API_KEY');
$reference_id = getenv('REFERENCE_ID');