<?php
include __DIR__.'/../vendor/autoload.php';

// connect to database 0 on 127.0.0.1
$redis = new Predis\Client('tcp://127.0.0.1:6379/0');

// Instantiate a new client
$client = new \SidekiqJob\Client($redis);

// define jobs with args
$jobs = [
    [ 'class' => 'ProcessImage', 'args' => [['url' => 'http://i.imgur.com/hlAsa4k.jpg'], true, 12]],
    [ 'class' => 'ProcessImage', 'args' => [['url' => 'http://i.imgur.com/hlAsa4k.jpg'], true, null]],
    [ 'class' => 'ProcessImage', 'args' => [['url' => 'http://i.imgur.com/hlAsa4k.jpg'], false, 45]]
];

// push jobs to a different queue
$ids = $client->pushBulk($jobs, 'images');

var_dump('Pushed job with ids:', $ids);