<?php

namespace CommandString\DiscordOAuth\Enums;

enum Endpoints: string
{
    private const API_BASE = "https://discord.com/api";
    case AUTHORIZE = "https://discord.com/oauth2/authorize";

    public static function buildEndpointUrl(string $uri, int $api_version = 6): string
    {
        return self::getApiBase($api_version) . "$uri";
    }

    public static function getApiBase(int $api_version = 6) {
        return self::API_BASE . "/v$api_version";
    }
}