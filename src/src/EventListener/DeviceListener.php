<?php

namespace App\EventListener;

use Doctrine\ORM\Mapping as ORM;
use Essedi\EasyCommerce\EventListener\DeviceListener as BaseDeviceListener;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\Device;
use Doctrine\ORM\Event\LifecycleEventArgs;
use App\Service\NotificationGenerator;

class DeviceListener extends BaseDeviceListener
{

    public function __construct(RequestStack $requestStack, NotificationGenerator $notGen)
    {
        parent::__construct($requestStack, $notGen);
    }

    /**
     * @ORM\PreUpdate 
     */
    public function preUpdateHandler(Device $device, LifecycleEventArgs $event)
    {
        parent::preUpdateHandler($device, $event);
    }

    protected function topicSubscriber(Device $device, LifecycleEventArgs $event)
    {
        parent::topicSubscriber($device, $event);
    }

}
