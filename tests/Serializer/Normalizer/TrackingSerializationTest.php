<?php

namespace Claudusd\MessageTracker\Tests\Serializer\Normalizer;

use Claudusd\MessageTracker\Error;
use Claudusd\MessageTracker\Serializer\Normalizer\ErrorNormalizer;
use Claudusd\MessageTracker\Serializer\Normalizer\StateNormalizer;
use Claudusd\MessageTracker\Serializer\Normalizer\TrackingNormalizer;
use Claudusd\MessageTracker\State;
use Claudusd\MessageTracker\Tracking;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Serializer;

class TrackingSerializationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Serializer
     */
    protected $serializer;

    protected function setUp()
    {
        parent::setUp();
        $this->serializer = new Serializer(
            [new TrackingNormalizer(), new ErrorNormalizer(), new ArrayDenormalizer(), new StateNormalizer()],
            [new JsonDecode(true), new JsonEncode()]
        );
    }

    public function testTrackingSerialization()
    {
        $data = new Tracking('foo', new State(State::STARTED));
        $data->addError(new Error('message 1', ['param_1' => 'param 1']));
        $data->addError(new Error('message 2', ['param_2' => 'param 2', 'param_3' => 'param 3']));

        $dataSerialized = $this->serializer->serialize($data, 'json');


        $this->assertEquals(
            [
                'id' => 'foo',
                'state' => 'started',
                'errors' => [
                    [
                        'message' => 'message 1',
                        'parameters' => ['param_1' => 'param 1']
                    ],
                    [
                        'message' => 'message 2',
                        'parameters' => ['param_2' => 'param 2', 'param_3' => 'param 3']
                    ]
                ]
            ],
            json_decode($dataSerialized, true)
        );
    }

    public function testTrackingDeserialization()
    {
        $trackingDeserialized = $this->serializer->deserialize(
            '{"id": "bar", "state": "failed", "errors" : [{"message":"message 1", "parameters": {"param_1": "param 1"}}]}',
            Tracking::class,
            'json'
        );


        $tracking = new Tracking('bar', new State(State::FAILED));
        $tracking->addError(new Error('message 1', ['param_1' => 'param 1']));
        $this->assertEquals($tracking, $trackingDeserialized);
    }
}