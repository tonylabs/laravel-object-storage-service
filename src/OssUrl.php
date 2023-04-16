<?php

namespace TONYLABS\ObjectStorageService;

class OssUrl
{
    /**
     * @var array
     */
    protected array $config = [
        'bucket' => null,
        'endpoint' => null
    ];

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = array_merge($this->config, $config);
    }

    /**
     * @param string $path
     * @return string
     */
    public function getURL(string $path): string
    {
        return $this->getEndpointDomain() . '/' . ltrim($path, '/');
    }

    /**
     * @return string
     */
    protected function getDomain(): string
    {
        if ($this->config['cdn_domain']) {
            return $this->getProtocol() . $this->config['cdn_domain'];
        }
        return $this->getEndpointDomain();
    }

    /**
     * @return string
     */
    protected function getEndpointDomain(): string
    {
        return "{$this->getProtocol()}://{$this->config['bucket']}.{$this->config['endpoint']}";
    }

    /**
     * @return string
     */
    protected function getProtocol(): string
    {
        return $this->config['ssl'] ? 'https' : 'http';
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->config['endpoint'] ?: '';
    }

    /**
     * @param string $url
     * @return string
     */
    public function correctDomain(string $url): string
    {
        if ($this->config['domain']) {
            return str_replace($this->getEndpointDomain(), $this->getDomain(), $url);
        }
        return $url;
    }
}