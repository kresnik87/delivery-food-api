<?php
declare(strict_types=1);
namespace KsK\Delivery\Domain\Shared;



use KsK\Shared\Domain\Aggregate\AggregateRoot;
use KsK\Shared\Domain\Equatable;

abstract class BaseModel extends AggregateRoot
{
    private int $publicId=0;
    private $createdAt;

    private $updatedAt;

    private bool $disabled = false;
    private \DateTime $disabledAt;

    public function onPrePersist()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * @return \DateTime
     */
    public function getDisabledAt(): \DateTime
    {
        return $this->disabledAt;
    }


    public function delete(): void
    {
        $this->disabled = true;
        $this->disabledAt = new \DateTime();
    }

    /**
     * @return int
     */
    public function getPublicId(): int
    {
        return $this->publicId;
    }

    public function equals(Equatable $other): bool
    {
        // TODO: Implement equals() method.
    }




}
