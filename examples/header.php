<?php

include __DIR__.'/../vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createMutable(__DIR__);
$dotenv->required(['REFERENCE_ID', 'API_KEY'])->notEmpty();
$dotenv->load();

$api_key = $_ENV('API_KEY');
$reference_id = $_ENV('REFERENCE_ID');
