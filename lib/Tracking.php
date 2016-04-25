<?php

namespace Claudusd\MessageTracker;

class Tracking
{
    /**
     * @var Error[]
     */
    protected $errors;

    /**
     * @var
     */
    protected $state;

    /**
     *
     */
    public function __construct()
    {
        $this->errors = array();   
    }

    /**
     *
     *
     * @return 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     *
     * 
     * @return Error[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     *
     *
     * @param Error $error
     */
    public function addError(Error $error)
    {
        $this->errors[] = $error;
    }
}
