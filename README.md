# Object Storage Service for Laravel

AliCloud Cloud Object Storage Service For Laravel Framework

### Composer
```shell
composer require tonylabs/laravel-object-storage-service
```


### Setup .env
```
OSS_ACCESS_KEY_ID=<Your aliyun accessKeyId, Required>
OSS_ACCESS_KEY_SECRET=<Your aliyun accessKeySecret, Required>
OSS_BUCKET=<Your oss bucket name, Required>
OSS_ENDPOINT=<Your oss endpoint domain, Required>
```

### Modify config/filesystems.php
```php

'default' => env('FILESYSTEM_DRIVER', 'oss'),
#...
'disks' =>[

    'oss' => [
        'driver'            => "oss",
        'access_key_id'     => env('OSS_ACCESS_KEY_ID'),           # Required
        'access_key_secret' => env('OSS_ACCESS_KEY_SECRET'),       # Required
        'bucket'            => env('OSS_BUCKET'),                  # Required
        'endpoint'          => env('OSS_ENDPOINT'),                # Required e.g. oss-cn-shanghai.aliyuncs.com
        'internal'          => env('OSS_INTERNAL', null),          # Optional e.g. oss-cn-shanghai-internal.aliyuncs.com
        "domain"            => env("OSS_DOMAIN", null),            // Optional, For example: oss.my-domain.com
        "is_cname"          => env("OSS_CNAME", false),            // Optional, if the Endpoint is a custom domain name, this must be true, see: https://github.com/aliyun/aliyun-oss-php-sdk/blob/572d0f8e099e8630ae7139ed3fdedb926c7a760f/src/OSS/OssClient.php#L113C1-L122C78
        "prefix"            => env("OSS_PREFIX", ""),              // Optional, The prefix of the store path
        "use_ssl"           => env("OSS_SSL", false),              // Optional, Whether to use HTTPS
        "reverse_proxy"     => env("OSS_REVERSE_PROXY", false),    // Optional, Whether to use the Reverse proxy, such as nginx
        "throw"             => env("OSS_THROW", false),            // Optional, Whether to throw an exception that causes an error
        "options"           => [],                                 // Optional, Add global configuration parameters, For example: [\OSS\OssClient::OSS_CHECK_MD5 => false]
        "macros"            => []                                  // Optional, Add custom Macro, For example: [\App\Macros\ListBuckets::class, \App\Macros\CreateBucket::class]
    ],

]
```


### Init
```php
use Illuminate\Support\Facades\Storage;

$objStorage = Storage::disk('oss');
```

### Write

Upload a local file to remote OSS
```php
Storage::disk('oss')->putFile('remote/path', 'local/path/file_name.ext');
Storage::disk('oss')->putFileAs('remote/path', 'local/path/file_name.ext', 'new_file_name.ext');
```

Streaming a file content and write into OSS as a file
```php
Storage::disk('oss')->put("dir/path/file.txt", file_get_contents("/local/path/file.txt"));
$fp = fopen("/local/path/file.txt","r");
Storage::disk('oss')->put("dir/path/file.txt", $fp);
fclose($fp);
```

Prepend or append new content to a file
```php
Storage::disk('oss')->prepend('remote/path/file_name', 'Bring your idea to life in no time.'); 
Storage::disk('oss')->append('remote/path/file_name', 'Bring your idea to life in no time.');
```

### Read

```php
Storage::disk('oss')->url('remote/path/file_name');
Storage::disk('oss')->get('remote/path/file_name'); 
Storage::disk('oss')->exists('remote/path/file_name'); 
Storage::disk('oss')->size('remote/path/file_name'); 
Storage::disk('oss')->lastModified('remote/path/file_name');
```

### Delete

```php
Storage::disk('oss')->delete('remote/path/file_name');
Storage::disk('oss')->delete(['remote/path/file_name_one', 'remote/path/file_name_two']);
```

### File Actions

```php
Storage::disk('oss')->copy('remote/path/file_name', 'remote/path/file_name_clone');
Storage::disk('oss')->move('remote/path/file_name', 'remote/path/new_file_name');
Storage::disk('oss')->rename('remote/path/file_name', 'remote/path/new_file_name');
```

### Folder Actions

```php
Storage::disk('oss')->makeDirectory('remote/path/folder_name');
Storage::disk('oss')->deleteDirectory('remote/path/folder_name');
Storage::disk('oss')->files('remote/path/folder');
Storage::disk('oss')->allFiles('remote/path/folder');
Storage::disk('oss')->directories('remote/path/folder');
Storage::disk('oss')->allDirectories('remote/path/folder');
```