<?php

namespace Claudusd\MessageTracker;

final class Error
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @param string $message
     * @param array $parameters
     */
    public function __construct($message, array $parameters = array())
    {
        $this->message = $message;
        $this->parameters = $parameters;
    }

    /**
     * @param string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
