<?php

namespace TONYLABS\ObjectStorageService;

use TONYLABS\ObjectStorageService\OssAdapter;
use TONYLABS\ObjectStorageService\OssException;
use Illuminate\Filesystem\FilesystemAdapter;
use JetBrains\PhpStorm\Pure;
use League\Flysystem\Config;
use OSS\OssClient;

class OssClientAdapter
{
    /**
     * @var OssAdapter
     */
    protected OssAdapter $adapter;

    /**
     * @param FilesystemAdapter $filesystemAdapter
     */
    public function __construct(FilesystemAdapter $filesystemAdapter)
    {
        $adapter = $filesystemAdapter->getAdapter();
        if (!$adapter instanceof OssAdapter) {
            throw new OssException('Invalid OSS Adapter: ' . $adapter::class, 0);
        }
        $this->adapter = $adapter;
    }

    /**
     * @return OssClient
     */
    #[Pure] public function client(): OssClient
    {
        return $this->adapter->getClient();
    }

    /**
     * @return string
     */
    #[Pure] public function bucket(): string
    {
        return $this->adapter->getBucket();
    }

    /**
     * @param string $path
     * @return string
     */
    #[Pure] public function path(string $path = ""): string
    {
        return $this->adapter->getPrefixer()->prefixPath($path);
    }
}