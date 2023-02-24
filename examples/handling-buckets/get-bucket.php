 <?php

include '../../vendor/autoload.php';

use Dotenv\Dotenv;
use Supabase\Storage\StorageClient;

$dotenv = Dotenv::createUnsafeImmutable('../../', '.env.test');
$dotenv->load();
$api_key = getenv('API_KEY');
$reference_id = getenv('REFERENCE_ID');

$client = new StorageClient($api_key, $reference_id);
$result = $client->getBucket('test-bucket');
$output = json_decode($result->getBody(), true);
