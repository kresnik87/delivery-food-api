<?php

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Interfaces\BusinessInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Business;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class CurrentBusinessExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{

    /**
     *
     * @var RequestStack
     */
    protected $requestStack;

    /**
     *
     * @var  EntityManagerInterface
     */
    protected $em;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(RequestStack $requestStack, EntityManager $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->requestStack = $requestStack;
        $this->em           = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    /**
     * {@inheritdoc}
     */
    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = [])
    {
//        $this->addWhere($queryBuilder, $resourceClass);
    }

    /**
     *
     * @param QueryBuilder $queryBuilder
     * @param string       $resourceClass
     */
    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass)
    {
        if (($resourceClass instanceof BusinessInterface || is_subclass_of($resourceClass, BusinessInterface::class)))
        {
            $rootAlias = $queryBuilder->getRootAliases()[0];
            $queryBuilder->andWhere(sprintf('%s.bussines = :business', $rootAlias));
            $queryBuilder->setParameter('business', $this->getBussinesId());
        }
    }

    /**
     * Gets Id of current Business from url
     * @return int|null
     * @throws NotFoundHttpException
     */
    protected function getBussinesId(): ?int
    {
            $token = $this->tokenStorage->getToken();
            if (isset($token))
            {
                $user = $token->getUser();
                if ($user && $user instanceof User && !$user->isSuperAdmin())
                {
                    return $user->getBussines()->getId();
                }
            }
            return null;
    }

}
