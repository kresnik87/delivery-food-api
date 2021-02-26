<?php

namespace App\EventListener;

use App\Entity\NotificationConfig;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\Event\LifecycleEventArgs;
use App\Service\NotificationGenerator;

class NotificationConfigListener
{

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var NotificationGenerator
     */
    protected $notGen;

    public function __construct(
        RequestStack $requestStack,
        NotificationGenerator $notGen)
    {
        $this->requestStack = $requestStack;
        $this->notGen       = $notGen;
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdateHandler(NotificationConfig $config, LifecycleEventArgs $event)
    {
        $this->topicSubscriber($config, $event);
    }

    protected function topicSubscriber(NotificationConfig $config, LifecycleEventArgs $event)
    {

        if ($event->hasChangedField(NotificationConfig::NOTIFICATION_TOPIC_NEWSLETTER))
        {
            if ($config->getNewsletter())
            {
                $this->notGen->subscribeUserToTopic(NotificationConfig::NOTIFICATION_TOPIC_NEWSLETTER, $config->getUser());
            }
            else
            {
                $this->notGen->unsubscribeUserToTopic(NotificationConfig::NOTIFICATION_TOPIC_NEWSLETTER, $config->getUser());
            }
        }

        if ($event->hasChangedField(NotificationConfig::NOTIFICATION_TOPIC_OFFERS))
        {
            if ($config->getOffers())
            {
                $this->notGen->subscribeUserToTopic(NotificationConfig::NOTIFICATION_TOPIC_OFFERS, $config->getUser());
            }
            else
            {
                $this->notGen->unsubscribeUserToTopic(NotificationConfig::NOTIFICATION_TOPIC_OFFERS, $config->getUser());
            }
        }

        if ($event->hasChangedField(NotificationConfig::NOTIFICATION_TOPIC_CAMPAIGNS))
        {
            if ($config->getCampaigns())
            {
                $this->notGen->subscribeUserToTopic(NotificationConfig::NOTIFICATION_TOPIC_CAMPAIGNS, $config->getUser());
            }
            else
            {
                $this->notGen->unsubscribeUserToTopic(NotificationConfig::NOTIFICATION_TOPIC_CAMPAIGNS, $config->getUser());
            }
        }
    }
}
