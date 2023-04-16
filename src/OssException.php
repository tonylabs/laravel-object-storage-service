<?php

namespace TONYLABS\ObjectStorageService;

use League\Flysystem\FilesystemException;
use RuntimeException;

class OssException extends RuntimeException implements FilesystemException
{

}