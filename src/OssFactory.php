<?php

namespace TONYLABS\ObjectStorageService;

use League\Flysystem\Filesystem;
use OSS\Core\OssException;
use OSS\OssClient;

class OssFactory
{
    /**
     * @param array $config
     * @param OssClient|null $client
     * @return OssAdapter
     * @throws OssException
     */
    public function createAdapter(array $config, OssClient $client = null): OssAdapter
    {
        is_null($client) && $client = $this->createClient($config);
        return new OssAdapter($client, $config['bucket'], $config['prefix'] ?? '', $config);
    }

    /**
     * @param array $config
     * @param OssClient|null $client
     * @return Filesystem
     * @throws OssException
     */
    public function createFilesystem(array $config, OssClient $client = null): Filesystem
    {
        return new Filesystem($this->createAdapter($config, $client));
    }

    /**
     * @param array $config
     * @return OssClient
     */
    public function createClient(array $config): OssClient
    {
        $endpoint = (new OssUrl($config))->getEndpoint();
        $client = new OssClient($config['access_key_id'], $config['access_key_secret'], $endpoint);
        !empty($config['ssl']) && $client->setUseSSL($config['ssl']);
        !empty($config['retries']) && $client->setMaxTries($config['retries']);
        !empty($config['timeout']) && $client->setTimeout($config['timeout']);
        !empty($config['connect_timeout']) && $client->setConnectTimeout($config['connect_timeout']);
        return $client;
    }
}