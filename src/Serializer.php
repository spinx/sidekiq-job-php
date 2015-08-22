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
    public function serialize($jobId, $class, $args = [], $retry = true)
    {
        $class = is_object($class) ? get_class($class) : $class;

        $data = [
            'class' => $class,
            'jid' => $jobId,
            'created_at' => microtime(true),
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
