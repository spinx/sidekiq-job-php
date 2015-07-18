<?php

namespace SidekiqJob;

/**
 * Class Serializer
 * @package SidekiqJob
 */
class Serializer
{
    /**
     * Serialize and normalize job data
     *
     * @param string        $jobId
     * @param object|string $class
     * @param array         $args
     * @return string
     * @throws exception Exception
     */
    public function serialize($jobId, $class, $args = [])
    {
        $class = is_object($class) ? get_class($class) : $class;
        $retry = (isset($args['retry']) && is_bool($args['retry'])) ? $args['retry'] : true;
        $createdAt = isset($args['created_at']) ? $args['created_at'] : microtime(true);

        if (!is_float($createdAt) && is_string($createdAt)) {
            throw new Exception('created_at argument needs to be in a unix epoch format. Use microtime(true).');
        }

        $data = [
            'class' => $class,
            'jid' => $jobId,
            'created_at' => $createdAt,
            'enqueued_at' => microtime(true),
            'args' => $args,
            'retry' => $retry,
        ];

        return json_encode($data);
    }

    /**
     * @param array $data
     * @return array
     */
    public function unserialize($data = [])
    {
        return json_decode($data, true);
    }
}
