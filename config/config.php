<?php

return [
    'driver' => 'oss',
    'access_key_id' => env('OSS_ACCESS_KEY_ID', ''),
    'access_key_secret' => env('OSS_ACCESS_KEY_SECRET', ''),
    'endpoint' => env('OSS_ENDPOINT', 'oss-cn-shanghai.aliyuncs.com'),
    'bucket' => env('OSS_BUCKET', ''),
    'domain' => env('OSS_DOMAIN', ''),
    'ssl' => env('OSS_SSL', true),
    'retries' => env('OSS_RETRIES', 3),
    'timeout' => env('OSS_TIMEOUT', 60),
    'connect_timeout' => env('OSS_CONNECT_TIMEOUT', 60)
];