<?php

namespace Claudusd\MessageTracker;

use Claudusd\MessageTracker\Exception\TrackingNotFoundException;

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
     * @throws TrackingNotFoundException If the tracking id is not found in the dataset.
     */
    public function get($trackingId);
}
