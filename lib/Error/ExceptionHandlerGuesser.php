<?php

namespace Claudusd\MessageTracker\Error;

use Claudusd\MessageTracker\Exception\ExceptionHandlerNotFoundException;
use Claudusd\MessageTracker\Traceable;

interface ExceptionHandlerGuesser
{
    /**
     * @param Traceable $traceable
     * @return ExceptionHandler
     * @throws ExceptionHandlerNotFoundException
     */
    public function guess(Traceable $traceable);
}