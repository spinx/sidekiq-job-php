<?php

namespace spec\SidekiqJob;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SerializerSpec extends ObjectBehavior
{

    function _get_valid_array($jobClass = 'JobClass', $jobId = '861e7b31b685646053322c46', $args = [], $retrn = true){
        return [
            'class' => $jobClass,
            'jobid' => $jobId,
            'args' => $args,
            'retry' => true
        ];
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SidekiqJob\Serializer');
    }

    function is_throws_exception_if_not_valid_arguments()
    {
        $this->serialize([], true, false)->shouldThrowExeption();
    }

    function it_returns_string(){
        $result = $this->serialize($this->_get_valid_array()['jobid'], $this->_get_valid_array()['class'], $this->_get_valid_array()['args']);
        $result->shouldBeString();
    }

    function it_unserializes(){
        $job = $this->_get_valid_array();
        $serialized = $this->serialize($job['jobid'], $job['class'], $job['args'])->getWrappedObject();
        $result = $this->unserialize($serialized);

        $result->shouldHaveKeyWithValue('jid', $job['jobid']);
        $result->shouldHaveKeyWithValue('class', $job['class']);
        $result->shouldHaveKeyWithValue('args', $job['args']);
        $result->shouldHaveKeyWithValue('retry', $job['retry']);
        $result->shouldHaveKey('created_at');
        $result->shouldHaveKey('enqueued_at');
    }

}
