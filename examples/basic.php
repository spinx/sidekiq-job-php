<?php
include __DIR__.'/../vendor/autoload.php';
function _print($id, $retry){
    var_dump(sprintf('Pushed job with id %s and retry:%d', $id, $retry));
}

// connect to database 0 on 127.0.0.1
$redis = new Predis\Client('tcp://127.0.0.1:6379/0');

// Instantiate a new client
$client = new \SidekiqJob\Client($redis);

// push a job with three arguments - args array needs to be sequential (not associative)
$args = [
    ['url' => 'http://i.imgur.com/hlAsa4k.jpg'],
    true,
    70
];

$id = $client->push('ProcessImage', $args, true);
_print($id, true);

$id = $client->push('ProcessImage', $args, false);
_print($id, false);
