<?php

include '../../vendor/autoload.php';

use Supabase\Storage\StorageClient;

if (!is_readable('../../.env.test')) {
    throw new \RuntimeException(sprintf('%s file is not readable', '../../.env.test'));
}

$lines = file('../../.env.test', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    
    if (strpos(trim($line), '#') === 0) {
        continue;
    }

    list($name, $value) = explode('=', $line, 2);
    $name = trim($name);
    $value = trim($value);

    if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
        putenv(sprintf('%s=%s', $name, $value));
        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
    }
}

$api_key = getenv('API_KEY');
$reference_id = getenv('REFERENCE_ID');

$client = new StorageClient($api_key, $reference_id);
$result = $client->getBucket('test-bucket');
print_r($result);