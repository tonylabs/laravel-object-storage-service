<?php

namespace TONYLABS\ObjectStorageService\Macros;

use Closure;
use Illuminate\Filesystem\FilesystemAdapter;
use OSS\Core\OssException;
use TONYLABS\ObjectStorageService\OssAdapter;
use TONYLABS\ObjectStorageService\OssException AS OssExceptionAlias;

class AppendObject implements OssMacro
{
    /**
     * @return string
     */
    public function name(): string
    {
        return 'appendObject';
    }

    /**
     * @return Closure
     */
    public function macro(): Closure
    {
        return function (string $path, string $content, int $position = 0, array $options = []) {
            /**
             * @var FilesystemAdapter $this
             */
            $objAdapter = new OssAdapter($this);

            try {
                return $objAdapter->client()->appendObject($objAdapter->bucket(), $objAdapter->path($path), $content, $position, $objAdapter->options($options));
            } catch (OssException $exception) {
                throw new OssExceptionAlias($exception->getErrorMessage(), 0, $exception);
            }
        };
    }
}