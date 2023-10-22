<?php

namespace KsK\Shared\Infrastructure\Helper\Downloader;

use Symfony\Component\HttpFoundation\File\UploadedFile;


interface DownloaderInterface
{

    public function downloadFile(string $url): ?UploadedFile;
}
