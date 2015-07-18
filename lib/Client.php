<?php

namespace SidekiqJob;

/**
 * Class Client
 * @package SidekiqJob
 */
class Client
{
    /** Default queue name */
    const QUEUE = 'default';

    /** Namespace  */
    protected $namespace;

    /** @var \Predis\Client */
    protected $redis;

    /** @var Serializer */
    protected $serializer;

    /** @var IdGenerator */
    protected $idGenerator;

    /**
     * Sidekiq job push
     *
     * @param \Predis\Client $redis
     * @param string         $namespace
     * @param Serializer     $serializer
     * @param IdGenerator    $idGenerator
     */
    public function __construct(\Predis\Client $redis, $namespace = null, $serializer = null, $idGenerator = null)
    {
        $this->redis = $redis;
        $this->namespace = ($namespace === null) ? '' : $namespace.':';
        $this->serializer = ($serializer === null) ? new Serializer() : $serializer;
        $this->idGenerator = ($idGenerator === null) ? new IdGenerator() : $idGenerator;
    }

    /**
     * Push a job
     *
     * @param string $class
     * @param array  $args
     * @param string $queue
     * @return string
     */
    public function push($class, $args = [], $queue = self::QUEUE)
    {
        $jobId = $this->idGenerator->generate();
        $this->atomicPush($jobId, $class, $args, $queue);

        return $jobId;
    }

    /**
     * Push a job
     *
     * @param float  $doAt
     * @param string $class
     * @param array  $args
     * @param string $queue
     * @return string
     */
    public function schedule($doAt, $class, $args = [], $queue = self::QUEUE)
    {
        $jobId = $this->idGenerator->generate();
        $this->atomicPush($jobId, $class, $args, $queue, $doAt);

        return $jobId;
    }

    /**
     * Push multiple jobs to queue
     *
     * Format:
     * $jobs = [
     *  [
     *      'class' => 'SomeClass',
     *      'args' => array()
     *  ]
     * ];
     *
     * @param array  $jobs
     * @param string $queue
     * @return string
     * @throws exception Exception
     */
    public function pushBulk($jobs = [], $queue = self::QUEUE)
    {
        $ids = [];
        foreach ($jobs as $job) {
            if (!isset($job['class'])) {
                throw new Exception('pushBulk: each job needs a job class');
            }
            if (!isset($job['args']) || !is_array($job['args'])) {
                throw new Exception('pushBulk: each job needs args');
            }

            $jobId = $this->idGenerator->generate();
            array_push($ids, $jobId);
            $this->atomicPush($jobId, $job['class'], $job['args'], $queue);
        }

        return $ids;
    }

    /**
     * Push job to redis
     *
     * @param string     $jobId
     * @param string     $class
     * @param array      $args
     * @param string     $queue
     * @param float|null $doAt
     * @throws exception Exception
     */
    private function atomicPush($jobId, $class, $args = [], $queue = self::QUEUE, $doAt = null)
    {
        if(array_values($args) !== $args){
            throw new Exception('Associative arrays in job args are not allowed');
        }

        if (!is_null($doAt) && !is_float($doAt) && is_string($doAt)) {
            throw new Exception('at argument needs to be in a unix epoch format. Use microtime(true).');
        }

        $job = $this->serializer->serialize($jobId, $class, $args);

        if ($doAt === null) {
            $this->redis->sadd('queues', $queue);
            $this->redis->lpush(sprintf('%squeue:%s', $this->namespace, $queue), $job);
        } else {
            $this->redis->zadd(sprintf('%sschedule', $this->namespace), [$job => $doAt]);
        }
    }
}
