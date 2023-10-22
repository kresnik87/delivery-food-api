<?php
namespace KsK\Shared\Infrastructure\Helper\Uploader;

interface UploaderInterface
{
public function getUrl(string $path):string;
public function getTempUrl(string $path):string;

public function downloadFile(string $file, string $path):string;
}
