<?php

namespace xXutianyi\FeishuSDK\SDK;

use xXutianyi\FeishuSDK\SDK;

class Authen extends SDK
{
    const AUTHEN_BY_CODE = "/authen/v1/access_token";

    public function GetBootUrl($redirectUrl, $state = ""): string
    {
        return "https://open.feishu.cn/open-apis/authen/v1/index?redirect_uri={$redirectUrl}&app_id={$this->config->AppID}&state={$state}";
    }

    public function AuthenByCode($code): array
    {
        $params = [
            'grant_type' => 'authorization_code',
            'code' => $code
        ];
        return $this->post(self::AUTHEN_BY_CODE, [], $params);
    }

}