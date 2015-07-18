<?php

namespace SidekiqJob;

/**
 * Class Client.
 */
class Client
{
    /** @var \Predis\Client */
    protected $redis;

    /** @var Serializer */
    protected $serializer;

    /** @var IdGenerator */
    protected $idGenerator;

    /**
     * Client constructor.
     *
     * @param \Predis\Client $redis
     * @param Serializer     $serializer
     * @param IdGenerator    $idGenerator
     */
    public function __construct(\Predis\Client $redis, $serializer = null, $idGenerator = null)
    {
        $this->redis = $redis;
        $this->serializer = ($serializer === null) ? new Serializer() : $serializer;
        $this->idGenerator = ($idGenerator === null) ? new IdGenerator() : $idGenerator;
    }

    public function push($class, $args = [], $retry = true, $queue = 'default')
    {
        var_dump("Pushing new job of ".$class);
    }
}
