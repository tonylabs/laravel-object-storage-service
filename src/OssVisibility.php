<?php

namespace TONYLABS\ObjectStorageService;

use OSS\OssClient;
use League\Flysystem\Visibility;

class OssVisibility
{
    /**
     * @param string $visibility
     * @return string
     */
    public function visibilityToAcl(string $visibility): string
    {
        return $visibility === Visibility::PUBLIC ? OssClient::OSS_ACL_TYPE_PUBLIC_READ : OssClient::OSS_ACL_TYPE_PRIVATE;
    }

    /**
     * @param string $acl
     * @return string
     */
    public function aclToVisibility(string $acl): string
    {
        return $acl === OssClient::OSS_ACL_TYPE_PRIVATE ? Visibility::PRIVATE : Visibility::PUBLIC;
    }
}