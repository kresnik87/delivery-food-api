<?php

namespace App\EventListener;

use Doctrine\ORM\Mapping as ORM;
use Essedi\EasyCommerce\EventListener\NotificationListener as BaseNotificationListener;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\Notification;
use Doctrine\ORM\Event\LifecycleEventArgs;
use App\Service\NotificationGenerator;

class NotificationListener extends BaseNotificationListener
{

    public function __construct(RequestStack $requestStack, NotificationGenerator $notGen)
    {
        parent::__construct($requestStack, $notGen);
    }

    /**
     * @ORM\PostPersist 
     */
    public function postPersistHandler(Notification $not, LifecycleEventArgs $event)
    {
        try
        {
            parent::postPersistHandler($not, $event);
        }
        catch (Exception $e)
        {
            if (getenv("APP_ENV") !== 'prod')
            {
                throw new Exception($e);
            }
        }
    }

}
