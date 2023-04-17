<?php

namespace TONYLABS\ObjectStorageService;

use OSS\OssClient;
use League\Flysystem\Config;

class OssOptions
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return OssOptions
     */
    public function setOptions(array $options): OssOptions
    {
        $this->options = $options;
        return $this;
    }

    public function mergeConfig(Config $config, OssVisibility $ossVisibility = null): array
    {
        $options = $config->get('options', []);
        if ($headers = $config->get('headers')) {
            $options[OssClient::OSS_HEADERS] = isset($options[OssClient::OSS_HEADERS]) ? array_merge($options[OssClient::OSS_HEADERS], $headers) : $headers;
        }
        if ($visibility = $config->get('visibility'))
        {
            is_null($ossVisibility) && $ossVisibility = new OssVisibility();
            $options[OssClient::OSS_HEADERS][OssClient::OSS_OBJECT_ACL] = $ossVisibility->visibilityToAcl($visibility);
        }
        return array_merge_recursive($this->options, $options);
    }
}