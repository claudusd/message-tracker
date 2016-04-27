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
     * @var
     */
    protected $state;

    /**
     * @var string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
        $this->errors = array();   
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
