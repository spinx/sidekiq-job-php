# sidekiq-job-php
Sidekiq job pusher for PHP

## Usage
--------

```
$redis = new Predis\Client('tcp://127.0.0.1:6379');

$client = new \SidekiqJob\Client($redis);

$client->push('ProcessImage', $args);
```

## Misc
-------

### Standards
[Symfony2](https://github.com/escapestudios/Symfony2-coding-standard).

### License
MIT. Use it as you wish

