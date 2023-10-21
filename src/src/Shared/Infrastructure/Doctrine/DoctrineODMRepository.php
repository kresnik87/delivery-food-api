<?php

declare(strict_types=1);

namespace KsK\Shared\Infrastructure\Doctrine;


use KsK\Shared\Domain\Repository\PaginatorInterface;
use KsK\Shared\Domain\Repository\RepositoryInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\Query\Builder;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use Doctrine\ODM\MongoDB\UnitOfWork;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Webmozart\Assert\Assert;

/**
 * @template T of object
 *
 * @implements RepositoryInterface<T>
 */
abstract class DoctrineODMRepository extends DocumentRepository implements RepositoryInterface
{
    private ?int $page = null;
    private ?int $itemsPerPage = null;

    private Builder $queryBuilder;

    public function __construct(
        DocumentManager $dm,
        string   $class,
        string          $alias)
    {
        $classMetadata = $dm->getClassMetadata($class);
        parent::__construct($dm, $dm->getUnitOfWork(), $classMetadata);
        $this->queryBuilder = $this->dm->createQueryBuilder($class);
    }

    public function getIterator(): \Iterator
    {
        if (null !== $paginator = $this->paginator()) {
            yield from $paginator;

            return;
        }

        yield from $this->queryBuilder->getQuery()->execute();
    }

    public function count(): int
    {
        if (null !== $paginator = $this->paginator()) {
            return count($paginator);
        }

        return (int)(clone $this->queryBuilder)
            ->select('count(1)')
            ->getQuery()
            ->getSingleResult();
    }

    public function paginator(): ?PaginatorInterface
    {
        if (null === $this->page || null === $this->itemsPerPage) {
            return null;
        }

        $firstResult = ($this->page - 1) * $this->itemsPerPage;
        $maxResults = $this->itemsPerPage;

        $repository = $this->filter(static function (Builder $qb) use ($firstResult, $maxResults) {
            $qb->popFirst()->limit($maxResults);
        });

        /** @var Paginator<T> $paginator */
        $paginator = new Paginator($repository->queryBuilder->getQuery());

        return new DoctrinePaginator($paginator);
    }

    public function withoutPagination(): static
    {
        $cloned = clone $this;
        $cloned->page = null;
        $cloned->itemsPerPage = null;

        return $cloned;
    }

    public function withPagination(int $page, int $itemsPerPage): static
    {
        Assert::positiveInteger($page);
        Assert::positiveInteger($itemsPerPage);

        $cloned = clone $this;
        $cloned->page = $page;
        $cloned->itemsPerPage = $itemsPerPage;

        return $cloned;
    }

    /**
     * @return static<T>
     */
    protected function filter(callable $filter): static
    {
        $cloned = clone $this;
        $filter($cloned->queryBuilder);

        return $cloned;
    }

    protected function query(): Builder
    {
        return clone $this->queryBuilder;
    }

    protected function __clone()
    {
        $this->queryBuilder = clone $this->queryBuilder;
    }


}
