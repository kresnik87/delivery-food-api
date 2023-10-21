<?php

namespace KsK\Shared\Infrastructure\Helper\Storage;



interface BSNStorageInterface
{

    public function resolvePath(object $model, ?string $file): ?string;
}
