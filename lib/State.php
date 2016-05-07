<?php

namespace Claudusd\MessageTracker;

final class State
{
    const PENDING = 'pending';

    const STARTED = 'started';

    const SUCCEEDED = 'succeeded';

    const FAILED = 'failed';

    /**
     * @var string
     */
    private $state;

    /**
     * @param string $state
     */
    public function __construct($state = null)
    {
        if (is_null($state)) {
            $state = self::PENDING;
        }

        if (!self::exists($state)) {
            throw new \DomainException();
        }

        $this->state = $state;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->state;
    }

    /**
     * @param $state
     * @return bool
     */
    public static function exists($state)
    {
        return in_array($state, self::all());
    }

    /**
     * @return array
     */
    public static function all()
    {
        return [self::PENDING, self::STARTED, self::SUCCEEDED, self::FAILED];
    }
}