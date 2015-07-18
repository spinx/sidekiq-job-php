# sidekiq-job-php
Sidekiq job pusher for PHP

## Usage

```php
$redis = new Predis\Client('tcp://127.0.0.1:6379');

$client = new \SidekiqJob\Client($redis);

$client->push('ProcessImage', ['argument1']);
```

More examples [here](https://github.com/spinx/sidekiq-job-php/tree/master/examples). 

## Misc

### Requirements
 - PHP 5.6 - would be entirely possible to support 5.3 but you really should upgrade!

### Todo
- Monolog support
- Statsd or similar support

### Standards
[Symfony2](https://github.com/escapestudios/Symfony2-coding-standard).

### License
MIT. Use it as you wish.

