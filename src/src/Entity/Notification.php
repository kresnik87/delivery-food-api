<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotificationRepository")
 * @ORM\EntityListeners({"App\EventListener\NotificationListener"})
 */
class Notification
{
    const NOTIFICATION_TYPE_PUSH   = 'push';
    const NOTIFICATION_TYPE_ENTITY = 'entity';
    const NOTIFICATION_TYPE_MAIL   = 'mail';


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;



    public $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=2500, nullable=true)
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NotificationUser", mappedBy="notification", cascade={"persist","remove"})
     */
    protected $notificationUsers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Device", inversedBy="notifications")
     * @ORM\JoinTable(name="notification_device",
     *       joinColumns={
     *      @ORM\JoinColumn(name="notification_id", referencedColumnName="id")
     *   },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="device_id", referencedColumnName="uuid")
     *    }
     * )
     */
    protected $devices;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="notifications")
     * @ORM\JoinTable(name="notification_users",
     *       joinColumns={
     *      @ORM\JoinColumn(name="notification_id", referencedColumnName="id")
     *   },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *    }
     * )
     */
    protected $users;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    protected $params;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    protected $mails;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    protected $topics;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    protected $types;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    protected $tokens;

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
        $this->notificationUsers = new ArrayCollection();
        $this->devices           = new ArrayCollection();
        $this->users             = new ArrayCollection();
        $this->createdDate       = new \dateTime();
        $this->updatedDate       = new \dateTime();
        $this->topics            = [NotificationConfig::NOTIFICATION_TOPIC_NEWSLETTER];
        $this->mails             = [];
        $this->params            = [];
        $this->tokens            = [];
        $this->types             = [self::NOTIFICATION_TYPE_ENTITY, self::NOTIFICATION_TYPE_MAIL, self::NOTIFICATION_TYPE_PUSH];
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|NotificationUser[]
     */
    public function getNotificationUsers(): Collection
    {
        return $this->notificationUsers;
    }

    public function addNotificationUser(NotificationUser $user): self
    {
        if (!$this->notificationUsers->contains($user))
        {
            $this->notificationUsers[] = $user;
            $user->setNotification($this);
        }

        return $this;
    }

    public function removeNotificationUser(NotificationUser $user): self
    {
        if ($this->notificationUsers->contains($user))
        {
            $this->notificationUsers->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getNotification() === $this)
            {
                $user->setNotification(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Device[]
     */
    public function getDevices(): Collection
    {
        return $this->devices;
    }

    public function addDevice(Device $device): self
    {
        if (!$this->devices->contains($device))
        {
            $this->devices[] = $device;
        }

        return $this;
    }

    public function removeDevice(Device $device): self
    {
        if ($this->devices->contains($device))
        {
            $this->devices->removeElement($device);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user))
        {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user))
        {
            $this->users->removeElement($user);
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

    public function getParams(): ?array
    {
        return $this->params;
    }

    public function setParams(?array $params): self
    {
        $this->params = $params;
        return $this;
    }

    public function addParam($param)
    {
        if (!in_array($param, $this->getParams()))
        {
            $this->params[] = $param;
        }
        return $this;
    }

    public function getMails()
    {
        return $this->mails;
    }

    public function addMail($mail)
    {
        if (!in_array($mail, $this->getParams()))
        {
            $this->mails[] = $mail;
        }
        return $this;
    }

    public function getTopics()
    {
        return $this->topics;
    }

    public function addTopic($topic)
    {
        if (!in_array($topic, $this->getParams()))
        {
            $this->topics[] = $topic;
        }
        return $this;
    }

    public function setMails($mails)
    {
        $this->mails = $mails;
        return $this;
    }

    public function setTopics($topics)
    {
        $this->topics = $topics;
        return $this;
    }

    public function getTypes()
    {
        return $this->types;
    }

    public function setTypes($types)
    {
        $this->types = $types;
        return $this;
    }

    public function addType($type)
    {
        if (!in_array($type, $this->getParams()))
        {
            $this->types[] = $type;
        }
        return $this;
    }

    public function sendMail()
    {
        if (in_array(self::NOTIFICATION_TYPE_MAIL, $this->getTypes()))
        {
            return true;
        }
        return false;
    }

    public function sendPush()
    {
        if (in_array(self::NOTIFICATION_TYPE_PUSH, $this->getTypes()))
        {
            return true;
        }
        return false;
    }

    public function sendEntity()
    {
        if (in_array(self::NOTIFICATION_TYPE_ENTITY, $this->getTypes()))
        {
            return true;
        }
        return false;
    }

    public function getTokens()
    {
        return $this->tokens;
    }

    public function setTokens($tokens)
    {
        $this->tokens = $tokens;
        return $this;
    }
}
