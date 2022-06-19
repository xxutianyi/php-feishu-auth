<?php

namespace xXutianyi\FeishuSDK;

use JetBrains\PhpStorm\ArrayShape;

class Config
{
    const GetTenantAccessTokenParams = [
        'app_id' => "string",
        'app_secret' => "string"
    ];

    public string $AppID;
    private string $AppSecret;

    public function __construct($AppID, $AppSecret)
    {
        $this->AppID = $AppID;
        $this->AppSecret = $AppSecret;
    }

    /**
     * @return array
     */
    #[ArrayShape(self::GetTenantAccessTokenParams)]
    public function GetAccessTokenParams(): array
    {
        return [
            'app_id' => $this->AppID,
            'app_secret' => $this->AppSecret
        ];
    }
}