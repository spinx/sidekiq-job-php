<?php

namespace spec\SidekiqJob;


class Job
{
    protected $retry;

    /**
     * Job constructor.
     *
     * @param $class
     * @param $queue
     * @param $retry
     */
    public function __construct($class, $queue = null, $retry = true)
    {
        $this->class = $class;
        $this->queue = $queue;
        $this->retry = $retry;
    }



}