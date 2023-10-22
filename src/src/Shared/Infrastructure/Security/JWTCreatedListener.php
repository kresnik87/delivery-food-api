<?php

namespace KsK\Shared\Infrastructure\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

final class JWTCreatedListener
{
    public function __construct(private readonly  RequestStack $requestStack)
    {
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $user = $event->getUser();
        $payload = $event->getData();
        $payload['roles'] = $user->getRoles();
        $payload['id'] = $user->getId()->value();
        $event->setData($payload);
    }
}
