<?php

namespace Claudusd\MessageTracker\Tests\Exception;

use Claudusd\MessageTracker\Exception\TrackingNotFoundException;

class TrackingNotFoundExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMessage()
    {
        $exception = new TrackingNotFoundException('foo');

        $this->assertEquals('The tracking id "foo" does\'nt exist', $exception->getMessage());  
    }
}
