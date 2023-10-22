<?php

namespace KsK\Delivery\Domain\Menu\Repository;

use KsK\Delivery\Domain\Menu\Menu;
use KsK\Delivery\Domain\Menu\MenuId;
use KsK\Shared\Domain\Criteria\Criteria;
use KsK\Shared\Domain\Repository\RepositoryInterface;

interface MenuRepositoryInterface extends RepositoryInterface
{
  public function save(Menu $menu): Menu;

  public function add(Menu $menu, bool $flush): Menu;

  public function findOrFail(MenuId $menuId): ?Menu;

  public function remove(Menu $menu, bool $flush);

  public function searchByCriteria(Criteria $criteria): static;
}
