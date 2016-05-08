<?php

namespace Claudusd\MessageTracker\Error;

use Claudusd\MessageTracker\Error;
use Claudusd\MessageTracker\Exception\ExceptionHandlerNotFoundException;
use Claudusd\MessageTracker\Traceable;
use Claudusd\MessageTracker\Tracker;

class ErrorProcessor
{
    /**
     * @var Tracker
     */
    private $tracker;

    /**
     * @var ExceptionHandlerGuesser
     */
    private $exceptionHandlerGuesser;

    /**
     * @param Tracker $tracker
     * @param ExceptionHandlerGuesser $exceptionHandlerGuesser
     */
    public function __construct(Tracker $tracker, ExceptionHandlerGuesser $exceptionHandlerGuesser)
    {
        $this->tracker = $tracker;
        $this->exceptionHandlerGuesser = $exceptionHandlerGuesser;
    }

    /**
     * @param Traceable $traceable
     * @param \Exception $exception
     */
    public function handleException(Traceable $traceable, \Exception $exception)
    {
        try {
            $handler = $this->exceptionHandlerGuesser->guess($traceable);
            $error = $handler->handle($traceable, $exception);
            if ($error) {
                $this->handleError($traceable, $error);
            }
        } catch(ExceptionHandlerNotFoundException $e) {

        }
    }

    /**
     * @param Traceable $traceable
     * @param Error|null $error
     */
    public function handleError(Traceable$traceable, Error $error)
    {
        $tracking = $this->tracker->get($traceable->getTrackingId());
        $tracking->addError($error);
    }
}