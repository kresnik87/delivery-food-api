<?php

namespace App\EventListener;

use Doctrine\ORM\Mapping as ORM;
use Essedi\EasyCommerce\EventListener\NotificationConfigListener as BaseNotificationConfigListener;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\Event\LifecycleEventArgs;
use App\Service\NotificationGenerator;

class NotificationConfigListener extends BaseNotificationConfigListener
{

    public function __construct(RequestStack $requestStack, NotificationGenerator $notGen)
    {
        parent::__construct($requestStack, $notGen);
    }

    /**
     * @ORM\PreUpdate 
     */
    public function preUpdateHandler(\App\Entity\NotificationConfig $config, LifecycleEventArgs $event)
    {
        parent::preUpdateHandler($config, $event);
    }

    protected function topicSubscriber(\App\Entity\NotificationConfig $config, LifecycleEventArgs $event)
    {
        parent::topicSubscriber($config, $event);
    }

}
