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
    public $redis;

    /** @var Serializer */
    protected $serializer;

    /** @var IdGenerator */
    protected $idGenerator;

    /**
     * Sidekiq job pusher init
     *
     * @param \Predis\Client $redis
     * @param string         $namespace
     * @param Serializer     $serializer
     * @param IdGenerator    $idGenerator
     */
    public function __construct(\Predis\Client $redis, $namespace = null, $serializer = null, $idGenerator = null)
    {
        $this->redis = $redis;
        $this->namespace = ($namespace === null) ? '' : (string) $namespace;
        $this->serializer = ($serializer === null) ? new Serializer() : $serializer;
        $this->idGenerator = ($idGenerator === null) ? new IdGenerator() : $idGenerator;
        $this->idGeneratorBatch = ($idGenerator === null) ? new IdGenerator(10) : $idGenerator;
    }

    /**
     * Push a job
     *
     * @param string $class
     * @param array  $args
     * @param bool   $retry
     * @param string $queue
     * @return string
     */
    public function push($class, $args = [], $retry = true, $queue = self::QUEUE)
    {
        $jobId = $this->idGenerator->generate();
        $this->atomicPush($jobId, $class, $args, $queue, $retry);

        return $jobId;
    }

    /**
     * Schedule a job at a certain time
     *
     * @param float  $doAt
     * @param string $class
     * @param array  $args
     * @param bool   $retry
     * @param string $queue
     * @return string
     */
    public function schedule($doAt, $class, $args = [], $retry = true, $queue = self::QUEUE)
    {
        $jobId = $this->idGenerator->generate();
        $this->atomicPush($jobId, $class, $args, $queue, $retry, $doAt);

        return $jobId;
    }

    /**
     * Push multiple jobs to queue
     *
     * Format:
     * $jobs = [
     *  [
     *      'class' => 'SomeClass',
     *      'args' => array(),
     *      'retry' => false,
     *      'at' => microtime(true)
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

            $retry = isset($job['retry']) ? $job['retry'] : true;
            $doAt = isset($job['at']) ? $job['at'] : null;

            $jobId = $this->idGenerator->generate();
            array_push($ids, $jobId);
            $this->atomicPush($jobId, $job['class'], $job['args'], $queue, $retry, $doAt);
        }

        return $ids;
    }

    public function pushBatch($jobs = [], $queue = self::QUEUE, )
    {
        
    }

    /**
     * Push job to redis
     *
     * @param string     $jobId
     * @param string     $class
     * @param array      $args
     * @param string     $queue
     * @param bool       $retry
     * @param float|null $doAt
     * @throws exception Exception
     */
    private function atomicPush($jobId, $class, $args = [], $queue = self::QUEUE, $retry = true, $doAt = null)
    {
        if (array_values($args) !== $args) {
            throw new Exception('Associative arrays in job args are not allowed');
        }

        if (!is_null($doAt) && !is_float($doAt) && is_string($doAt)) {
            throw new Exception('at argument needs to be in a unix epoch format. Use microtime(true).');
        }

        $job = $this->serializer->serialize($jobId, $class, $args, $retry);

        if ($doAt === null) {
            $this->redis->sadd($this->name('queues'), $queue);
            $this->redis->lpush($this->name('queue', $queue), $job);
        } else {
            $this->redis->zadd($this->name('schedule'), [$job => $doAt]);
        }
    }

    /**
     * @param string ...$key
     * @return string
     */
    private function name()
    {
        return implode(':', array_filter(array_merge([$this->namespace], func_get_args()), 'strlen'));
    }

    /**
     * @return \Predis\Client
     */
    public function getRedis()
    {
        return $this->redis;
    }
}
