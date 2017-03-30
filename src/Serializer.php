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
     * @param bool          $retry
     *
     * @return string
     * @throws JsonEncodeException
     */
    public function serialize($jobId, $class, $args = [], $retry = true)
    {
        $class = is_object($class) ? get_class($class) : $class;

        $data = [
            'class'       => $class,
            'jid'         => $jobId,
            'created_at'  => microtime(true),
            'enqueued_at' => microtime(true),
            'args'        => $args,
            'retry'       => $retry,
        ];

        $jsonEncodedData = json_encode($data);

        if ($jsonEncodedData === false) {
            throw new JsonEncodeException($data, json_last_error(), json_last_error_msg());
        }

        return $jsonEncodedData;
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
