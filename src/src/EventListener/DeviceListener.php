<?php

namespace App\EventListener;

use App\Entity\AccessToken;
use App\Entity\NotificationConfig;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\Device;
use Doctrine\ORM\Event\LifecycleEventArgs;
use App\Service\NotificationGenerator;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

class DeviceListener
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var \Essedi\EasyCommerce\Service\NotificationGenerator
     */
    protected $notGen;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    public function __construct(
        RequestStack $requestStack,
        NotificationGenerator $notGen,
        TokenStorageInterface $tokenStorage)
    {
        $this->requestStack = $requestStack;
        $this->notGen       = $notGen;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersistHandler(Device $device, LifecycleEventArgs $event)
    {
        $this->addDeviceSession($device, $event);
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdateHandler(Device $device, LifecycleEventArgs $event)
    {
//        $this->topicSubscriber($device, $event);
        $this->addDeviceSession($device, $event);
    }

    protected function topicSubscriber(Device $device, LifecycleEventArgs $event)
    {

        if ($event->hasChangedField('user'))
        {

            //needs apply configuration user to device
            //remove previos user from newsletter topic and add new
            if ($device->getNewsletter())
            {
                $this->notGen->subscribeUserToTopic(NotificationConfig::NOTIFICATION_TOPIC_NEWSLETTER, $device->getUser());
            }
            else
            {
                $this->notGen->unsubscribeUserToTopic(NotificationConfig::NOTIFICATION_TOPIC_NEWSLETTER, $device->getUser());
            }
        }
    }

    protected function addDeviceSession(Device $device, LifecycleEventArgs $event)
    {
        //check if session was change (introduce all)
        $token = $this->tokenStorage->getToken();
        if ($token)
        {
            $em          = $event->getEntityManager();
            $accesstoken = $em->getRepository(AccessToken::class)->findOneByToken($token);
            if ($accesstoken)
            {
                $device->addAccessToken($accesstoken);
            }
        }
    }
}
