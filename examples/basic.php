<?php
include __DIR__.'/../vendor/autoload.php';

$redis = new Predis\Client('tcp://127.0.0.1:6379');

$client = new \SidekiqJob\Client($redis, new \SidekiqJob\Serializer(), new \SidekiqJob\IdGenerator());

$client->push('ProcessImage');