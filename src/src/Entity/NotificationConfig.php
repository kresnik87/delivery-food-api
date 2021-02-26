<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotificationConfigRepository")
 * @ORM\EntityListeners({"App\EventListener\NotificationConfigListener"})
 */
class NotificationConfig
{
    const NOTIFICATION_TOPIC_NEWSLETTER  = 'newsletter';
    const NOTIFICATION_TOPIC_OFFERS      = 'offers';
    const NOTIFICATION_TOPIC_CAMPAIGNS   = 'campaigns';
    const NOTIFICATION_TOPIC_ORDERSTATUS = 'orderstatus';

    /**
     * @var integer
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    protected $orderStatus = true;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    protected $campaigns = true;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    protected $offers = true;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    protected $newsletter = true;

    /**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $createdDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedDate;

    public function getId()
    {
        return $this->id;
    }

    public function getOrderStatus()
    {
        return $this->orderStatus;
    }

    public function getCampaigns()
    {
        return $this->campaigns;
    }

    public function getOffers()
    {
        return $this->offers;
    }

    public function getNewsletter()
    {
        return $this->newsletter;
    }

    public function setOrderStatus($orderStatus)
    {
        $this->orderStatus = $orderStatus;
        return $this;
    }

    public function setCampaigns($campaigns)
    {
        $this->campaigns = $campaigns;
        return $this;
    }

    public function setOffers($offers)
    {
        $this->offers = $offers;
        return $this;
    }

    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

}
