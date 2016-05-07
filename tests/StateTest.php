<?php

namespace Claudusd\MessageTracker\Tests;

use Claudusd\MessageTracker\State;

class StateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \DomainException
     */
    public function testInvalidState()
    {
        new State('foo');
    }

    public function testDefaultStateisPending()
    {
        $state = new State();
        $this->assertEquals(State::PENDING, $state);
    }

    /**
     * @dataProvider state
     */
    public function testExist($state)
    {
        $this->assertTrue(State::exists($state));
    }

    /**
     * @dataProvider state
     */
    public function testConstructor($stateValue)
    {
        $state = new State($stateValue);
        $this->assertEquals($stateValue, $state);
    }

    public function state()
    {
        return [[State::PENDING],[State::STARTED], [State::SUCCEEDED], [State::FAILED]];
    }

}