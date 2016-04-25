<?php

namespace Claudusd\MessageTracker;

interface Traceable
{
    /**
     * Get tracking id
     *
     * @return string
     */
    public function getTrackingId();
}
