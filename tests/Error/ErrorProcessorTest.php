<?php

namespace Claudusd\MessageTracker\Tests\Error;

use Claudusd\MessageTracker\Error;
use Claudusd\MessageTracker\Error\ErrorProcessor;
use Claudusd\MessageTracker\Error\ExceptionHandler;
use Claudusd\MessageTracker\Error\ExceptionHandlerGuesser;
use Claudusd\MessageTracker\Exception\ExceptionHandlerNotFoundException;
use Claudusd\MessageTracker\Traceable;
use Claudusd\MessageTracker\Tracker;
use Claudusd\MessageTracker\Tracking;
use Mockery as M;

class ErrorProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ErrorProcessor
     */
    protected $errorProcessor;

    /**
     * @var Tracker | M\MockInterface
     */
    protected $mockedTracker;

    /**
     * @var ExceptionHandlerGuesser | M\MockInterface
     */
    protected $mockedExceptionHandlerGuesser;

    protected function setUp()
    {
        parent::setUp();
        $this->mockedTracker = M::mock(Tracker::class);
        $this->mockedExceptionHandlerGuesser = M::mock(ExceptionHandlerGuesser::class);
        $this->errorProcessor = new ErrorProcessor($this->mockedTracker, $this->mockedExceptionHandlerGuesser);
    }

    public function testHandleException()
    {
        /** @var Traceable $mockedTraceable|M\MockInterface */
        $mockedTraceable = M::mock(Traceable::class);
        $mockedTraceable->shouldReceive('getTrackingId')
            ->andReturn('foo');
        /** @var \Exception $mockedException */
        $mockedException = M::mock(\Exception::class);

        $mockedExceptionHandler = M::mock(ExceptionHandler::class);

        $mockedExceptionHandler->shouldReceive('handle')
            ->with($mockedTraceable, $mockedException)
            ->andReturn(new Error('message'));

        $this->mockedExceptionHandlerGuesser->shouldReceive('guess')
            ->with($mockedTraceable)
            ->andReturn($mockedExceptionHandler);

        $tracking = new Tracking('foo');

        $this->mockedTracker->shouldReceive('get')
            ->with('foo')
            ->andReturn($tracking);


        $this->errorProcessor->handleException($mockedTraceable, $mockedException);

        $expectedTracking = new Tracking('foo');
        $expectedTracking->addError(new Error('message'));
        $this->assertEquals($expectedTracking, $tracking);
    }

    public function testHandlerExceptionWithNoHandlerFound()
    {
        $mockedTraceable = M::mock(Traceable::class);
        $mockedException = M::mock(\Exception::class);

        $this->mockedExceptionHandlerGuesser->shouldReceive('guess')
            ->with($mockedTraceable)
            ->andThrow(new ExceptionHandlerNotFoundException($mockedException));

        $this->errorProcessor->handleException($mockedTraceable, $mockedException);
    }

}