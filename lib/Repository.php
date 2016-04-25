<?php

namespace Claudusd\MessageTracker;

interface Repository
{
    /**
     *
     *
     * @param Tracking $tracking
     */
    public function persist(Tracking $tracking);

    /**
     *
     *
     * @param Tracking $tracking
     */
    public function delete(Tracking $tracking);

    /**
     *
     *
     * @param string $trackingId
     * @return Tracking
     */
    public function get($trackingId);
}
