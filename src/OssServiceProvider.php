<?php

namespace TONYLABS\ObjectStorageService;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Foundation\CachesConfiguration;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;

class OssServiceProvider extends ServiceProvider
{
    /**
     * @return void
     * @throws BindingResolutionException
     */
    public function register()
    {
        $this->mergeOssConfig();
    }

    /**
     * @return void
     * @throws BindingResolutionException
     */
    protected function mergeOssConfig()
    {
        if ($this->app instanceof CachesConfiguration && $this->app->configurationIsCached()) {
            return;
        }

        #only if oss driver defined in filesystems config file
        $config = $this->app->make('config');
        $disks = $config->get('filesystems.disks', []);
        $drivers = array_column($disks, 'driver');
        if (in_array('oss', $drivers)) {
            return;
        }

        $config->set('filesystems.disks.oss', array_merge(
            require __DIR__ . "/../config/config.php",
            $config->get('filesystems.disks.oss', [])
        ));
    }

    /**
     * @return void
     * @throws BindingResolutionException
     */
    public function boot()
    {
        $this->app->make('filesystem')->extend('oss', function (Application $app, array $config) {
            $objClient = $app->make(OssFactory::class)->createClient($config);
            $objAdapter = new OssAdapter($objClient, $config['bucket'], $config['prefix'] ?? '', $config);
            $objDriver = new Filesystem($objAdapter);
            $filesystem = new FilesystemAdapter($objDriver, $objAdapter, $config);
            (new FilesystemMacroManager($filesystem))->defaultRegister()->register($config['macros'] ?? []);
            return $filesystem;
        });
    }
}