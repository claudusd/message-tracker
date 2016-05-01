<?php

namespace Claudusd\MessageTracker\Error;

use Claudusd\MessageTracker\Error;
use Claudusd\MessageTracker\Traceable;

interface ExceptionHandler
{
    /**
     * @param Traceable $traceable
     * @param \Exception $exception
     * @return Error|null
     */
    public function handle(Traceable $traceable, \Exception $exception);
}