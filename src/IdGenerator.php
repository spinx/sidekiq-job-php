<?php

namespace SidekiqJob;

/**
 * Class IdGenerator
 * @package SidekiqJob
 */
class IdGenerator
{
    /**
     * @var int
     */
    protected $bytes;

    /**
     * @param int $bytes
     */
    public function __construct($bytes = 12)
    {
        $this->bytes = $bytes;
    }


    /**
     * Generates byte random id
     *
     * @see https://github.com/mperham/sidekiq/blob/master/lib/sidekiq/client.rb#L218
     * @return number
     */
    public function generate()
    {
        return bin2hex(openssl_random_pseudo_bytes($this->bytes));
    }
}
