<?php

namespace spec\SidekiqJob;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SidekiqJob\Exception');
    }
}
