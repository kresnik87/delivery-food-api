<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Interfaces\BusinessInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @Vich\Uploadable
 */
class User extends BaseUser
{
    const ROLE_USER        = "ROLE_USER";
    const ROLE_ADMIN       = "ROLE_ADMIN";


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user-read","bussines-read"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user-read","user-write","bussines-read"})
     */
    protected $name;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Bussines", inversedBy="user", cascade={"persist", "remove"})
     * @Groups({"user-read"})
     */
    private $bussines;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user-read","user-write"})
     */
    protected $nif;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user-write"})
     */
    protected $surnames;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"user-read","user-write"})
     * @var string
     */
    protected $phone;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $createdDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedDate;
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"user-read"})
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="UserImage", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    public function __construct()
    {
        parent::__construct();
        $this->createdDate = new \dateTime();
        $this->updatedDate = new \dateTime();
    }

    public function __toString()
    {
        return $this->getName() . " " . $this->getSurnames() . " (" . $this->getId() . ")";
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNif(): ?string
    {
        return $this->nif;
    }

    public function setNif(?string $nif): self
    {
        $this->nif = $nif;

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

     /**
     * @Groups({"user-read"})
     */
    public function getSurnames(): ?string
    {
        return $this->surnames." asasas";
    }

    public function setSurnames(?string $surnames): self
    {
        $this->surnames = $surnames;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username): self
    {
        $this->username = $username;

        return $this;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
        return $this;
    }

    public function getEnabled()
    {
        return $this->enabled;
    }

    public function getLastLogin()
    {
        return $this->lastLogin;
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

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {

        $this->image = $image;

        return $this;
    }

    public function isSuperAdmin()
    {
        return parent::isSuperAdmin(); // TODO: Change the autogenerated stub
    }

}
