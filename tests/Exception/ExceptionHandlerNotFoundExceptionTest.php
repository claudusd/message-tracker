<?php

namespace Claudusd\MessageTracker\Tests\Exception;

use Claudusd\MessageTracker\Exception\ExceptionHandlerNotFoundException;

class ExceptionHandlerNotFoundExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMessage()
    {
        $e = new \RuntimeException();
        $exception = new ExceptionHandlerNotFoundException($e);
        $this->assertEquals(
            'No Exception Handler founded for the exception RuntimeException',
            $exception->getMessage()
        );
    }
}