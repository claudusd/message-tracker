<?php

namespace Claudusd\MessageTracker;

class Tracking
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var Error[]
     */
    protected $errors;

    /**
     * @var State
     */
    protected $state;

    /**
     * @param $id
     * @param State|null $state
     */
    public function __construct($id, State $state = null)
    {
        $this->id = $id;
        $this->errors = array();
        $this->state = $state ? $state : new State();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     *
     * @return State
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
