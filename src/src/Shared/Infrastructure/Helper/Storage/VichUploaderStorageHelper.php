<?php

namespace KsK\Shared\Infrastructure\Helper\Storage;

use KsK\Shared\Domain\Logger;
use Vich\UploaderBundle\Storage\StorageInterface;

final class VichUploaderStorageHelper implements BSNStorageInterface
{
    const LOGGER_NAME = 'ksk.shared.infra.helper.storage_vich';
    const FILENAME = 'file';

    public function __construct(
        private Logger                    $logger,
        private readonly StorageInterface $storage,

    )
    {
    }


    public function resolvePath(object $model, ?string $file = self::FILENAME): ?string
    {
        try {
            return $this->storage->resolvePath($model, $file);
        } catch (\Exception $exception) {
            $this->logger->critical(sprintf('[%s]: Error: %s', self::LOGGER_NAME, $exception->getMessage()));
            throw  new StorageException($exception->getMessage());
        }
    }
}
