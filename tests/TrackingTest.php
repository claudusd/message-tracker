<?php

namespace Claudusd\MessageTracker\Tests;

use Claudusd\MessageTracker\Error;
use Claudusd\MessageTracker\Tracking;
use Mockery as M;

class TrackingTest extends \PHPUnit_Framework_TestCase
{
    public function testGetErrors()
    {
        $error1 = new Error('Error 1');

        $tracking = new Tracking();
        $tracking->addError($error1);
        
        $this->assertEquals([$error1], $tracking->getErrors());
    }
}
