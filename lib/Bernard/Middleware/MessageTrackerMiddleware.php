<?php

namespace Claudusd\MessageTracker\Bernard\Middleware;

use Bernard\Envelope;
use Bernard\Middleware;
use Bernard\Queue;
use Claudusd\MessageTracker\Traceable;
use Claudusd\MessageTracker\Tracker;

class MessageTrackerMiddleware implements Middleware
{
    /**
     * @var Middleware
     */
    private $next;

    /**
     * @var Tracker
     */
    private $tracker;

    public function __construct(Middleware $next, Tracker $tracker)
    {
        $this->next = $next;
        $this->tracker = $tracker;
    }

    public function call(Envelope $envelope, Queue $queue)
    {
        $isTreacable = $envelope->getMessage() instanceof Traceable;

        try {
            if ($isTreacable) {
                $tracking = $this->tracker->get($envelope->getMessage()->getTrackingId());
                $this->tracker->flush($envelope->getMessage());
            }

            $this->next->call($envelope, $queue);

            if ($isTreacable) {
                $tracking = $this->tracker->get($envelope->getMessage()->getTrackingId());
                $this->tracker->flush($envelope->getMessage());
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

}