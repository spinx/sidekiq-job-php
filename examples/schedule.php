<?php
include __DIR__.'/../vendor/autoload.php';

// connect to database 0 on 127.0.0.1
$redis = new Predis\Client('tcp://127.0.0.1:6379/0');

// Instantiate a new client
$client = new \SidekiqJob\Client($redis);

// schedule in exactly one hour (requires epoch time with microseconds)
$time = microtime(true) + (60*60);

// push a job with one argument
$id = $client->schedule(
    $time,
    'ProcessImage',
    [
        ['url' => 'http://i.imgur.com/hlAsa4k.jpg'],
        false
    ]
);

var_dump(sprintf('Scheduled job with id %s', $id));