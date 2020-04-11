<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlateRepository")
 */
class Plate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $cost;

       /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $images;

   /**
    * Este lo tengo pensado para poner en una tabla y la idea a futuro es poder recomendar platos por ingredientes
     * @ORM\Column(type="string", length=255)
     */
    private $ingredient;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $rate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaurant", inversedBy="plates")
     */
    private $restaurant;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setCost($cost): self
    {
      $this->cost = $cost;
      return $this;
    }

    public function getCost(): ?float
    {
      return $this->cost;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    } 

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(string $images): self
    {
        $this->images = $images;

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

    public function setRestaurant(Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }  

     public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRate($rate)
    {
      $this->rate = $rate;
      return $this;
    }

}
