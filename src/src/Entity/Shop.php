<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Interfaces\BusinessInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ShopRepository")
 */
class Shop extends Place implements BusinessInterface
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductStock", mappedBy="shop")
     * @Groups({"shop-read"})
     */
    private $stockProd;

    public function __construct()
    {
        parent::__construct();
        $this->stockProd = new ArrayCollection();
    }

    /**
     * @return Collection|ProductStock[]
     */
    public function getStockProd(): Collection
    {
        return $this->stockProd;
    }

    public function addStockProd(ProductStock $stockProd): self
    {
        if (!$this->stockProd->contains($stockProd)) {
            $this->stockProd[] = $stockProd;
            $stockProd->setShop($this);
        }

        return $this;
    }

    public function removeStockProd(ProductStock $stockProd): self
    {
        if ($this->stockProd->contains($stockProd)) {
            $this->stockProd->removeElement($stockProd);
            // set the owning side to null (unless already changed)
            if ($stockProd->getShop() === $this) {
                $stockProd->setShop(null);
            }
        }

        return $this;
    }
}
