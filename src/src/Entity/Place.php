<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PlaceRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"restaurant" = "Restaurant","shop"="Shop"})
 * @Vich\Uploadable
 */
abstract class Place
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"place-read","rest-read","shop-read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"rest-read","rest-write","shop-read","shop-write"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"rest-read","rest-write","shop-read","shop-write"})
     */
    private $lat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"rest-read","rest-write","shop-read","shop-write"})
     */
    private $lng;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"rest-read","shop-read"})
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="placeImage", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bussines", inversedBy="places")
     */
    private $bussines;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ImagesPlace", mappedBy="place")
     * @Groups({"rest-read","shop-read"})
     */
    private $images;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $createdDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedDate;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->createdDate = new \dateTime();
        $this->updatedDate = new \dateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(?string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?string
    {
        return $this->lng;
    }

    public function setLng(?string $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getBussines(): ?Bussines
    {
        return $this->bussines;
    }

    public function setBussines(?Bussines $bussines): self
    {
        $this->bussines = $bussines;

        return $this;
    }

    /**
     * @return Collection|ImagesPlace[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ImagesPlace $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setPlace($this);
        }

        return $this;
    }

    public function removeImage(ImagesPlace $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getPlace() === $this) {
                $image->setPlace(null);
            }
        }

        return $this;
    }

    public function getCreatedDate(): ?\dateTime
    {
        return $this->createdDate;
    }

    public function setCreatedDate(?\dateTime $createdDate = null): self
    {
        $this->createdDate = $createdDate ? $createdDate : new \dateTime();
        return $this;
    }

    public function getUpdatedDate(): ?\dateTime
    {
        return $this->updatedDate;
    }

    public function setUpdatedDate(?\dateTime $updatedDate = null): self
    {
        $this->updatedDate = $updatedDate ? $updatedDate : new \dateTime();
        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile $image
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        if ($image) {
            $this->setUpdatedDate();
        }

    }

    public function getImageFile()
    {
        return $this->imageFile;
    }


}
