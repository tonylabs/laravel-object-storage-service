<?php

namespace TONYLABS\ObjectStorageService\Macros;

use Closure;

interface OssMacro
{
    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return Closure
     */
    public function macro(): Closure;
}