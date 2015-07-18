# sidekiq-job-php

[![Build Status](https://scrutinizer-ci.com/g/spinx/sidekiq-job-php/badges/build.png?b=master)](https://scrutinizer-ci.com/g/spinx/sidekiq-job-php/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/spinx/sidekiq-job-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/spinx/sidekiq-job-php/?branch=master)

Push and schedule jobs to Sidekiq from PHP

## Installation

The recommended way to install this library is through
[Composer](http://getcomposer.org/). Require the `spinx/sidekiq-job-php` package
into your `composer.json` file:

```json
{
    "require": {
        "spinx/sidekiq-job-php": "*"
    }
}
```

**Inportant:** you should browse the
[`spinx/sidekiq-job-php`](https://packagist.org/packages/spinx/sidekiq-job-php)
page to choose a stable version to use, avoid the `*` meta constraint.

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

