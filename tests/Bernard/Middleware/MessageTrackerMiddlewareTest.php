<?php

namespace Claudusd\MessageTracker\Tests\Bernard\Middleware;

use Bernard\Envelope;
use Bernard\Middleware;
use Bernard\Queue;
use Claudusd\MessageTracker\Bernard\Middleware\MessageTrackerMiddleware;
use Claudusd\MessageTracker\Tracker;
use Mockery as M;

class MessageTrackerMiddlewareTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MessageTrackerMiddleware
     */
    protected $messageTrackerMiddleware;

    /**
     * @var Middleware|M\MockInterface
     */
    protected $mockedMiddleware;

    /**
     * @var Tracker|M\MockInterface
     */
    protected $mockedTracker;

    protected function setUp()
    {
        parent::setUp();
        $this->mockedMiddleware = M::mock(Middleware::class);
        $this->mockedTracker = M::mock(Tracker::class);
        $this->messageTrackerMiddleware = new MessageTrackerMiddleware($this->mockedMiddleware, $this->mockedTracker);
    }

    public function testEnvelopeIsNotTraceable()
    {
        /** @var M\MockInterface|Queue $mockedQueue */
        $mockedQueue = M::mock(Queue::class);

        $mockedMessage = M::mock();

        /** @var M\MockInterface|Envelope $mockedEnvelope */
        $mockedEnvelope = M::mock(Envelope::class);
        $mockedEnvelope->shouldReceive('getMessage')
            ->andReturn($mockedMessage);

        $this->mockedMiddleware->shouldReceive('call')
            ->with($mockedEnvelope, $mockedQueue)
            ->once();

        $this->messageTrackerMiddleware->call($mockedEnvelope, $mockedQueue);
    }

    public function testEnvelopeIsNotTraceableAndThrowException()
    {
        /** @var M\MockInterface|Queue $mockedQueue */
        $mockedQueue = M::mock(Queue::class);

        $mockedMessage = M::mock();

        /** @var M\MockInterface|Envelope $mockedEnvelope */
        $mockedEnvelope = M::mock(Envelope::class);
        $mockedEnvelope->shouldReceive('getMessage')
            ->andReturn($mockedMessage);

        $exception = new \Exception();

        $this->mockedMiddleware->shouldReceive('call')
            ->with($mockedEnvelope, $mockedQueue)
            ->once()
            ->andThrow($exception);

        try {
            $this->messageTrackerMiddleware->call($mockedEnvelope, $mockedQueue);
        } catch (\Exception $e) {
            $this->assertSame($exception, $e);
        }
    }

}