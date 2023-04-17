<?php

namespace TONYLABS\ObjectStorageService\Macros;

use Closure;
use OSS\Core\OssException;
use Illuminate\Filesystem\FilesystemAdapter;
use TONYLABS\ObjectStorageService\OssAdapter;
use TONYLABS\ObjectStorageService\OssException AS OssExceptionAlias;

class AppendFile implements OssMacro
{
    /**
     * @return string
     */
    public function name(): string
    {
        return 'appendFile';
    }

    /**
     * @return Closure
     */
    public function macro(): Closure
    {
        return function (string $path, string $file, int $position = 0, array $options = []) {
            /**
             * @var FilesystemAdapter $this
             */
            $objAdapter = new OssAdapter($this);

            try {
                return $objAdapter->client()->appendFile($objAdapter->bucket(), $objAdapter->path($path), $file, $position, $objAdapter->options($options));
            } catch (OssException $exception) {
                throw new OssExceptionAlias($exception->getErrorMessage(), 0, $exception);
            }
        };
    }
}
