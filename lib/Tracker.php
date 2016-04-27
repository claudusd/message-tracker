<?php

namespace Claudusd\MessageTracker;

class Tracker
{
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var Tracking[]
     */
    protected $trackingList;

    /**
     * @var Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
        $this->trackingList = [];
    }

    /**
     * 
     *
     * @param Traceable $traceable
     */
    public function registerMessage(Traceable $traceable)
    {
        $tracking = new Tracking($traceable->getTrackingId());
        $this->repository->persist($tracking);                  
    }

    /**
     *
     *
     * @param Traceable $traceable
     * @param string $message
     * @param array $parameters 
     */
    public function addError(Traceable $traceable, $message, array $parameters = array())
    {
        $tracking = $this->get($traceable->getTrackingId());

        $error = new Error($message, $parameters);

        $tracking->addError($error);
    }

    /**
     *
     *
     * @param Traceable $traceable
     */
    public function flush(Traceable $traceable)
    {
        $tracking = $this->get($traceable->getTrackingId());

        $this->repository->persist($tracking);

        unset($this->trackingList[$traceable->getTrackingId()]);
    }

    /**
     *
     *
     * @param string $trackingId
     * @return Tracking
     */
    public function get($trackingId)
    {
        if (!isset($this->trackingList[$trackingId])) {
            $this->trackingList[$trackingId] = $this->repository->get($trackingId);
        }
        return $this->trackingList[$trackingId];
    }
}
