<?php

namespace Claudusd\MessageTracker\Exception;

class ExceptionHandlerNotFoundException extends \RuntimeException
{
    public function __construct(\Exception $exception)
    {
        parent::__construct(sprintf('No Exception Handler founded for the exception %s', get_class($exception)));
    }
}