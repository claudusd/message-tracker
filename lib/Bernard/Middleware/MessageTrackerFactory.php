<?php

namespace Claudusd\MessageTracker\Bernard\Middleware;

use Bernard\Middleware;
use Claudusd\MessageTracker\Tracker;

class MessageTrackerFactory
{
    /**
     * @var Tracker
     */
    private $tracker;

    /**
     * @param Tracker $tracker
     */
    public function __construct(Tracker $tracker)
    {
        $this->tracker = $tracker;
    }

    /**
     * @param Middleware $next
     * @return MessageTrackerMiddleware
     */
    public function __invoke(Middleware $next)
    {
        return new MessageTrackerMiddleware($next, $this->tracker);
    }
}