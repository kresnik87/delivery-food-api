<?php

namespace KsK\Delivery\Domain\Shared;

use Symfony\Component\HttpFoundation\File\File;

abstract class FileObject extends BaseModel
{
    protected ?File $file=null;

    protected ?string $path=null;

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    public function getFile()
    {
        return $this->file;
    }


    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $file
     */
    public function setFile(?File $file = null): void
    {
        $this->file = $file;
        if (null !== $file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdatedAt(new \DateTimeImmutable());
        }
    }

    /**
     * @param string|null $path
     */
    public function setPath(?string $path): void
    {
        $this->path = $path;
    }

}
