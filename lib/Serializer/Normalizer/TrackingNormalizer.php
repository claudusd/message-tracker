<?php

namespace Claudusd\MessageTracker\Serializer\Normalizer;

use Claudusd\MessageTracker\Error;
use Claudusd\MessageTracker\Tracking;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

class TrackingNormalizer implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
{
    /**
     * @var SerializerInterface|DenormalizerInterface
     */
    private $serializer;

    /**
     * {@inheritdoc}
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        if (!$serializer instanceof DenormalizerInterface) {
            throw new InvalidArgumentException('Expected a serializer that also implements DenormalizerInterface.');
        }

        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = array())
    {
        $dataNormalized = [
            'id' => $object->getId(),
        ];

        $errorNormalized = [];
        foreach ($object->getErrors() as $error) {
            $errorNormalized[] = $this->serializer->normalize($error, $format, $context);
        }
        if (!empty($errorNormalized)) {
            $dataNormalized['errors'] = $errorNormalized;
        }

        return $dataNormalized;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Tracking;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $tracking = new Tracking($data['id']);
        $errors = $this->serializer->denormalize($data['errors'], Error::class.'[]', $format, $context);
        foreach ($errors as $error) {
            $tracking->addError($error);
        }
        return $tracking;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type == Tracking::class;
    }
}