<?php

namespace spec\SidekiqJob;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IdGeneratorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SidekiqJob\IdGenerator');
    }

    function it_generates_string_id()
    {
        $this->generate()->shouldBeString();
    }

    function it_generates_valid_length()
    {
        $this->generate()->shouldbeOfLengh(24);
    }

    function it_should_be_alphanumeric()
    {
        $this->generate()->shouldBeAlphanumeric();
    }

    /**
     * Naive way of testing uniqueness, I know
     */
    function it_should_be_unique(){
        $ids = [];
        $iterations = 100;

        for($i=0; $i < $iterations; $i++){
            $ids[] = $this->getWrappedObject()->generate();
        }

        return (count(array_values($ids)) === $iterations);
    }


    public function getMatchers()
    {
        return [
            'beOfLengh' => function ($subject, $key) {
                return (strlen($subject) == $key);
            },
            'beAlphanumeric' => function ($subject) {
                return ctype_alnum($subject);
            }
        ];
    }
}
