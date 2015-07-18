<?php

namespace SidekiqJob;

/**
 * Class Serializer
 * @package SidekiqJob
 */
class Serializer
{
    /**
     * @param array $data
     * @return string
     */
    public function serialize($data = [])
    {
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
