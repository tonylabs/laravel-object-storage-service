<?php

namespace TONYLABS\ObjectStorageService;

use TONYLABS\ObjectStorageService\OssException AS OssExceptionAlias;
use TONYLABS\ObjectStorageService\Macros\OssMacro;
use TONYLABS\ObjectStorageService\Macros\AppendFile;
use TONYLABS\ObjectStorageService\Macros\AppendObject;
use Illuminate\Filesystem\FilesystemAdapter;

class FilesystemMacroManager
{
    /**
     * @var FilesystemAdapter
     */
    protected FilesystemAdapter $filesystemAdapter;

    /**
     * @var array
     */
    protected array $defaultMacros = [
        AppendFile::class,
        AppendObject::class,
    ];

    /**
     * @param FilesystemAdapter $filesystemAdapter
     */
    public function __construct(FilesystemAdapter $filesystemAdapter)
    {
        $this->filesystemAdapter = $filesystemAdapter;
    }

    /**
     * @return $this
     */
    public function defaultRegister(): FilesystemMacroManager
    {
        $this->register($this->defaultMacros);
        return $this;
    }

    /**
     * @param array $macros
     * @return $this
     */
    public function register(array $macros): FilesystemMacroManager
    {
        foreach ($macros as $macro) {
            $filesystemMacro = new $macro();
            if (!$filesystemMacro instanceof OssMacro) {
                throw new OssExceptionAlias('Invalid macro detected: '.$filesystemMacro::class, 0);
            }
            $this->filesystemAdapter::macro($filesystemMacro->name(), $filesystemMacro->macro());
        }
        return $this;
    }
}