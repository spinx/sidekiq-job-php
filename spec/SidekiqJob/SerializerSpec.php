<?php

namespace spec\SidekiqJob;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SerializerSpec extends ObjectBehavior
{
    const VALID_STRING = '';

    const VALID_ARRAY = [
        'class' => 'JobClass',
        'jobid' => '861e7b31b685646053322c46',
        'args' => []
    ];

    function it_is_initializable()
    {
        $this->shouldHaveType('SidekiqJob\Serializer');
    }

    function is_throws_exception_if_not_valid_arguments()
    {
        $this->serialize([], true, false)->shouldThrowExeption();
    }

    function it_returns_string(){
        $this->serialize(self::VALID_ARRAY['jobid'], self::VALID_ARRAY['class'], self::VALID_ARRAY['args'])->shouldBeString();
    }


}
