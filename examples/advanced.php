<?php
include __DIR__.'/../vendor/autoload.php';

// connect to database 0 on 127.0.0.1
$redis = new Predis\Client([
    'host' => 'localhost',
    'port' => '6379',
    'database' => 0,
]);

// Instantiate a new client within 'users' namespace
$client = new \SidekiqJob\Client($redis, 'users');

// push a job with three arguments - args array needs to be sequential (not associative)
$args = [
    ['url' => 'http://i.imgur.com/hlAsa4k.jpg'],
    true,
    70
];

$id = $client->push('ProcessImage', $args);

var_dump(sprintf('Pushed job with id %s', $id));