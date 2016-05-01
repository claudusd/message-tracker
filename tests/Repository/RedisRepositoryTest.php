<?php

namespace Claudusd\MessageTracker\Tests\Repository;

use Claudusd\MessageTracker\Repository;
use Claudusd\MessageTracker\Tracking;
use Claudusd\MessageTracker\Repository\RedisRepository;
use Mockery as M;
use Symfony\Component\Serializer\SerializerInterface;

class RedisRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RedisRepository
     */
    protected $redisRepository;

    /**
     * @var \Redis|M\MockInterface
     */
    protected $mockedRedis;

    /**
     * @var SerializerInterface|M\MockInterface
     */
    protected $mockedSerializer;

    protected function setUp()
    {
        parent::setUp();
        $this->mockedRedis = M::mock('\Redis');
        $this->mockedSerializer = M::mock(SerializerInterface::class);
        $this->redisRepository = new RedisRepository($this->mockedRedis, $this->mockedSerializer);
    }

    public function testIsAnRepository()
    {
        $this->assertTrue($this->redisRepository instanceof Repository);
    }

    public function testPersist()
    {
        $tracking = new Tracking('foo');

        $this->mockedSerializer->shouldReceive('serialize')
            ->with($tracking, 'json')
            ->andReturn('serializedData');

        $this->mockedRedis->shouldReceive('hSet')
            ->once()
            ->with('tracking', 'foo', 'serializedData');

        
        $this->redisRepository->persist($tracking);
    }

    public function testDelete()
    {
        $tracking =new Tracking('foo');

        $this->mockedRedis->shouldReceive('hDel')
            ->with('tracking', 'foo');


        $this->redisRepository->delete($tracking);
    }

    /**
     * @expectedException Claudusd\MessageTracker\Exception\TrackingNotFoundException
     */
    public function testGetTrackingNotFound()
    {
        $this->mockedRedis->shouldReceive('hGet')
            ->with('tracking', 'bar')
            ->andReturn(false);

        $this->redisRepository->get('bar');
    }

    public function testGetTracking()
    {
        $this->mockedRedis->shouldReceive('hGet')
            ->with('tracking', 'bar')
            ->andReturn('serializedData');

        $expectedResult = M::mock();

        $this->mockedSerializer->shouldReceive('deserialize')
            ->with('serializedData', Tracking::class, 'json')
            ->andReturn($expectedResult);

        $result = $this->redisRepository->get('bar');

        $this->assertSame($expectedResult, $result);
    }
}
