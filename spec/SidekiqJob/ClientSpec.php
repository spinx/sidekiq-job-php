<?php

namespace spec\SidekiqJob;

use M6Web\Component\RedisMock\RedisMockFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClientSpec extends ObjectBehavior
{

    function let()
    {
        $factory = new RedisMockFactory();
        $redis = $factory->getAdapter('\Predis\Client', true);
        $this->beConstructedWith($redis);
    }

    function it_should_use_defaults(){
        return true;
//        $this->push('JobClass')->shouldBeAlphanumeric();
//        $redis = $this->getRedis()->getWrappedObject();
//        dump($this->redis->type('queue:default')->getWrappedObject());
//        dump($this->redis->lpop('queue:default')->getWrappedObject());
//        dump($redis->getWrappedObject()->lpop('queue:default'));
//            ->type('queue:default')->shouldBeEqualTo('list');
    }

    public function getMatchers() : array
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
