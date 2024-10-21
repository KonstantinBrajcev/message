<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client(['verify' => false]);
$response = $client->get('https://api.telegram.org/bot7455283283:AAFAf8AD146uj63yUMPq7SXSPMujFUK4XSE/getMe');

echo $response->getBody();
