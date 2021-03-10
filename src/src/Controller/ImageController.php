<?php

namespace App\Controller;

use App\Entity\Place;
use App\Entity\User;
use FOS\UserBundle\Mailer\TwigSwiftMailer;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Storage\StorageInterface;

class ImageController extends AbstractController
{
    /**
     * @var LoggerInterface
     */
    public $logger;

    /**
     * @var StorageInterface
     */
    protected $storage;

    public function __construct(
        LoggerInterface $logger,
        StorageInterface $storage
    )
    {
        $this->logger = $logger;
        $this->storage   = $storage;
    }

    public function userImageAction(Request $request, $id = null)
    {
        $uploadedFile = $request->files->get('file');
        //get user
        $user         = $id ? $this->getDoctrine()->getRepository(User::class)->find($id) : $this->getUser();
        $user->setImageFile($uploadedFile);
        //save data
        $em           = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new Response(getEnv("BASE_URL") . $this->storage->resolveUri($user, "imageFile"));
    }
    public function placeImageAction(Request $request, $id = null)
    {
        $uploadedFile = $request->files->get('file');
        //get user
        $place         = $id ? $this->getDoctrine()->getRepository(Place::class)->find($id) : null;
        if(is_null($place)){
            return new Response("place.not_found", Response::HTTP_NOT_FOUND);
        }
        $place->setImageFile($uploadedFile);
        //save data
        $em           = $this->getDoctrine()->getManager();
        $em->persist($place);
        $em->flush();

        return new Response(getEnv("BASE_URL") . $this->storage->resolveUri($place, "imageFile"));
    }
}
