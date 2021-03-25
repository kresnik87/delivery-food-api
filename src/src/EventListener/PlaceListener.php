<?php

namespace App\EventListener;

use App\Entity\Place;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\Bussines;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PlaceListener
{
    /**
     * @var RequestStack
     */
    protected $requestStack;


    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    public function __construct(
        RequestStack $requestStack,
        TokenStorageInterface $tokenStorage)
    {
        $this->requestStack = $requestStack;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersistHandler(Place $place, LifecycleEventArgs $event)
    {
        $userInterface = $this->tokenStorage->getToken()->getUser();
        $em = $event->getEntityManager();
        /** @var User $user */
        $user = $em->getRepository(User::class)->findOneBy(["username"=>$userInterface->getUsername()]);
        if(isset($user) && !$user->isSuperAdmin()){
            $place->setBussines($user->getBussines());
        }
    }


}
