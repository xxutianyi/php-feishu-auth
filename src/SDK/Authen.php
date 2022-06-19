<?php

namespace xXutianyi\FeishuSDK\SDK;

use xXutianyi\FeishuSDK\SDK;

class Authen extends SDK
{
    const AUTHEN_BY_CODE = "/authen/v1/access_token";

    public function AuthenByCode($code): array
    {
        $params = [
            'grant_type' => 'authorization_code',
            'code' => $code
        ];
        return $this->post(self::AUTHEN_BY_CODE, [], $params);
    }

}