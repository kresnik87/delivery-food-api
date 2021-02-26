<?php

namespace App\EventListener;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\Notification;
use Doctrine\ORM\Event\LifecycleEventArgs;

class NotificationListener

{

    /**
     * @var RequestStack
     */
    protected $requestStack;


    public function __construct(
        RequestStack $requestStack
        )
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @ORM\PostPersist
     */
    public function postPersistHandler(Notification $not, LifecycleEventArgs $event)
    {
        //send push when creates
//        $this->notGen->sendNotification($not); // Send manually on subscription event to catch easyadmin addition
    }


}
