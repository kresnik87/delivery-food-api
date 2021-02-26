<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\BussinesRepository")
 * @ORM\EntityListeners({"App\EventListener\BussinesListener"})
 */
class Bussines
{
    const TYPE_FOOD        = "type_food";
    const TYPE_SHOP       = "type_shop";

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"bussines-read", "user-read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"bussines-read","bussines-write"})
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"bussines-read","bussines-write","user-read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"bussines-read","bussines-write"})
     */
    private $logo;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="bussines")
     * @Groups({"bussines-read"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Place", mappedBy="bussines")
     */
    private $places;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PaymentStatus", cascade={"persist", "remove"})
     */
    private $paymentStatus;

    public function __construct()
    {
        $this->places = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
        $newBussines = null === $user ? null : $this;
        if ($user->getBussines() !== $newBussines) {
            $user->setBussines($newBussines);
        }

        return $this;
    }

    /**
     * @return Collection|Place[]
     */
    public function getPlaces(): Collection
    {
        return $this->places;
    }

    public function addPlace(Place $place): self
    {
        if (!$this->places->contains($place)) {
            $this->places[] = $place;
            $place->setBussines($this);
        }

        return $this;
    }

    public function removePlace(Place $place): self
    {
        if ($this->places->contains($place)) {
            $this->places->removeElement($place);
            // set the owning side to null (unless already changed)
            if ($place->getBussines() === $this) {
                $place->setBussines(null);
            }
        }

        return $this;
    }

    public function getPaymentStatus(): ?PaymentStatus
    {
        return $this->paymentStatus;
    }

    public function setPaymentStatus(?PaymentStatus $paymentStatus): self
    {
        $this->paymentStatus = $paymentStatus;

        return $this;
    }
}
