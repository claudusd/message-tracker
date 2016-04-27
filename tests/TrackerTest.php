<?php

namespace Claudusd\MessageTracker\Tests;

use Claudusd\MessageTracker\Repository;
use Claudusd\MessageTracker\Traceable;
use Claudusd\MessageTracker\Tracker;
use Claudusd\MessageTracker\Tracking;
use Mockery as M;

class TrackerTest extends \PHPUnit_Framework_TestCase
{
    /**
      * @var Tracker
      */
    protected $tracker;
    
    /**
     * @var Repository|M\MockInterface
     */
    protected $mockedRepository;

    protected function setUp()
    {
        $this->mockedRepository = M::mock('Claudusd\MessageTracker\Repository');
        $this->tracker = new Tracker($this->mockedRepository);
    }

    public function testRegisterMessage()
    {
        $mockedTraceable = M::mock('Claudusd\MessageTracker\Traceable',
            [
                'getTrackingId' => 'foo'
            ]);

        $this->mockedRepository->shouldReceive('persist')
            ->with(M::on(function($arg){
                return true;
            }));


        $this->tracker->registerMessage($mockedTraceable);
    }

    public function testAddError()
    {
        $mockedTraceable = M::mock('Claudusd\MessageTracker\Traceable');
        $mockedTraceable->shouldReceive('getTrackingId')
            ->andReturn('foo'); 

        $mockedTracking = M::mock('Claudusd\MessageTracker\Tracking');        
        $mockedTracking->shouldReceive('addError')
            ->with(M::on(function($arg){
                return true;
            }))
            ->once();        

        $this->mockedRepository->shouldReceive('get')
            ->once()
            ->with('foo')
            ->andReturn($mockedTracking);       


        $this->tracker->addError($mockedTraceable, 'My message', array('my_param' => 'My Parameter'));
    }

    public function testFlush()
    {
        $mockedTraceable = M::mock('Claudusd\MessageTracker\Traceable');
        $mockedTraceable->shouldReceive('getTrackingId')
            ->andReturn('bar');
        
        $mockedTracking = M::mock('Claudusd\MessageTracker\Tracking');

        $this->mockedRepository->shouldReceive('persist')
            ->once()
            ->with($mockedTracking);

        $this->mockedRepository->shouldReceive('get')
            ->once()
            ->with('bar')
            ->andReturn($mockedTracking);

        
        $this->tracker->flush($mockedTraceable);
    }

    public function testGet()
    {
        $mockedTracking = M::mock('Claudusd\MessageTracker\Tracking');

        $this->mockedRepository->shouldReceive('get')
            ->once()
            ->with('bar')
            ->andReturn($mockedTracking);

        
        $this->assertSame($mockedTracking, $this->tracker->get('bar'));
        $this->assertSame($mockedTracking, $this->tracker->get('bar'));
    }
}
