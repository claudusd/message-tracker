<?php

namespace Claudusd\MessageTracker\Repository;

use Claudusd\MessageTracker\Repository;
use Claudusd\MessageTracker\Tracking;
use Claudusd\MessageTracker\Exception\TrackingNotFoundException;
use Symfony\Component\Serializer\SerializerInterface;

class RedisRepository implements Repository
{
    /**
     * @var Redis
     */
    private $redis;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var array
     */
    protected $options;

    /**
     * @param \Redis $redis
     * @param SerializerInterface $serializer
     * @param array $options
     */
    public function __construct(\Redis $redis, SerializerInterface $serializer, $options = [])
    {
        $this->redis = $redis;
        $this->serializer = $serializer;
        $this->options = array_merge(
            [
                'key_tracking' => 'tracking'
            ],
            $options
        );
    }

    /**
     * {@inheritdoc}
     */
    public function persist(Tracking $tracking)
    {
        $this->redis->hSet(
            $this->options['key_tracking'],
            $tracking->getId(),
            $this->serializer->serialize($tracking, 'json')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Tracking $tracking)
    {
        $this->redis->hDel($this->options['key_tracking'], $tracking->getId());
    }
        
    /**
     * {@inheritdoc}
     */
    public function get($trackingId)
    {
        $result = $this->redis->hGet($this->options['key_tracking'], $trackingId);
        if (!$result) {
            throw new TrackingNotFoundException('The tracking "'.$trackingId.'" not found');
        }
        return $this->serializer->deserialize($result, Tracking::class, 'json');
    }
}
