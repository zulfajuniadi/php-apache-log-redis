<?php

require_once('vendor/autoload.php');
Dotenv::load(__DIR__);

$length = $_ENV['log_length'];
$path = $argv[1];
$log = file_get_contents('php://stdin'); 

$client = new Predis\Client([
    'scheme' => $_ENV['redis_scheme'],
    'host'   => $_ENV['redis_host'],
    'port'   => $_ENV['redis_port'],
]);

$client->executeRaw(['LTRIM', $path, 0, $length]);
$client->executeRaw(['LPUSH', $path, trim($log)]);

exit(0);