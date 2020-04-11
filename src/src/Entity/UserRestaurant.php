<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRestaurantRepository")
 */
class UserRestaurant
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $username;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaurant", inversedBy="users")
     */
    private $restaurant;


    public function getId(): ?int
    {
        return $this->id;
    } 

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    } 

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    } 

    public function getUserName(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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


}
