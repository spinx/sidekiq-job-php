<?php

namespace SidekiqJob;

/**
 * Class IdGenerator
 * @package SidekiqJob
 */
class IdGenerator
{
    /**
     * Generates 12 byte random id
     *
     * @see https://github.com/mperham/sidekiq/blob/master/lib/sidekiq/client.rb#L222
     * @return number
     */
    public function generate()
    {
        return bin2hex(openssl_random_pseudo_bytes(12));
    }
}
