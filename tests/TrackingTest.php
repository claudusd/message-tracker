<?php

namespace Claudusd\MessageTracker\Tests;

use Claudusd\MessageTracker\Error;
use Claudusd\MessageTracker\State;
use Claudusd\MessageTracker\Tracking;
use Mockery as M;

class TrackingTest extends \PHPUnit_Framework_TestCase
{
    public function testGetErrors()
    {
        $error1 = new Error('Error 1');

        $tracking = new Tracking('foo');
        $tracking->addError($error1);
        
        $this->assertEquals([$error1], $tracking->getErrors());
    }

    public function testGetId()
    {
        $tracking = new Tracking('bar');

        $this->assertEquals('bar', $tracking->getId());
    }

    public function testGetStateDefault()
    {
        $tracking = new Tracking('foo');
        $this->assertEquals(State::PENDING, $tracking->getState());
    }

    public function testGetState()
    {
        $state = new State(State::STARTED);
        $tracking = new Tracking('bar', $state);
        $this->assertSame($state, $tracking->getState());
    }
}
