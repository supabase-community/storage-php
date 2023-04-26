<?php

include __DIR__.'/../vendor/autoload.php';

use Supabase\Storage\Util\EnvSetup;

$keys = EnvSetup::env(__DIR__);
$api_key = $keys['API_KEY'];
$reference_id = $keys['REFERENCE_ID'];
