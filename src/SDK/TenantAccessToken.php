<?php

namespace xXutianyi\FeishuSDK\SDK;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\CacheItem;
use xXutianyi\FeishuSDK\Config;
use xXutianyi\FeishuSDK\utils\HttpCall;

class TenantAccessToken
{
    const INTERNAL_ACCESS_TOKEN = "/auth/v3/tenant_access_token/internal";

    const INTERNAL_ACCESS_TOKEN_CACHE_KEY = "xXutianyi.feishu.internal.tenant_access_token";

    const BASE_URL = "https://open.feishu.cn/open-apis";

    private array $params;

    private FilesystemAdapter $cache;
    private CacheItem $TenantAccessTokenInstance;

    /**
     * @param Config $config
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function __construct(Config $config)
    {
        //初始化 cache 实例
        $this->cache = new FilesystemAdapter();
        $cacheKey = self::INTERNAL_ACCESS_TOKEN_CACHE_KEY;
        $this->TenantAccessTokenInstance = $this->cache->getItem($cacheKey);

        //初始化配置
        $this->params = $config->GetAccessTokenParams();
        $this->GetTenantAccessToken();
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function GetTenantAccessToken(): string
    {
        $TenantAccessToken = $this->TenantAccessTokenInstance->get();
        if ($TenantAccessToken) {
            return $TenantAccessToken;
        }
        return $this->RefreshTenantAccessToken();
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function RefreshTenantAccessToken(): string
    {
        $url = self::BASE_URL . self::INTERNAL_ACCESS_TOKEN;
        $call = HttpCall::post($url, [], $this->params);
        $call = json_decode($call, true);
        $this->TenantAccessTokenInstance->set($call['tenant_access_token']);
        $this->TenantAccessTokenInstance->expiresAfter($call['expire']);
        $this->cache->save($this->TenantAccessTokenInstance);
        return $this->TenantAccessTokenInstance->get();
    }
}