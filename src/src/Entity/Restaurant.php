<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\RestaurantRepository")
 */
class Restaurant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

       /**
     * @ORM\Column(type="string", length=15)
     */
    private $cell;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

   /**
     * @ORM\Column(type="string", length=15)
     */
    private $phone;

    /**
     * @ORM\Column(type="integer")
     */
    private $rate;



    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pate", mappedBy="restaurant")
     */
    private $plates;

        /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserRestaurant", mappedBy="restaurant")
     */
    private $users;


    public function __construct()
    {
        $this->plates = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lat;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lng;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    } 

    public function getCell(): ?string
    {
        return $this->cell;
    }

    public function setCell(string $cell): self
    {
        $this->cell = $cell;

        return $this;
    } 

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(?float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

     public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate($rate)
    {
      $this->rate = $rate;
      return $this;
    }

   /**
     * @return Collection|Plate[]
     */
    public function getPlates(): Collection
    {
        return $this->plates;
    }

   /**
     * @return Collection|UserRestaurant[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }
    
    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(?float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }
}
