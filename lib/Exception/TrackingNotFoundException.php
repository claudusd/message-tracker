<?php

namespace Claudusd\MessageTracker\Exception;

class TrackingNotFoundException extends \RuntimeException
{
    /**
     * @param string $trackinigId
     */
    public function __construct($trackingId)
    {
        parent::__construct('The tracking id "'.$trackingId.'" does\'nt exist');
    }
}
