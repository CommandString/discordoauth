<?php

namespace CommandString\DiscordOAuth\Users;

/**
 * @see https://discord.com/developers/docs/resources/user#user-object-premium-types
 */
enum PremiumTypes: int
{
    case NONE = 0;
    case NITRO_CLASSIC = 1;
    case NITRO = 2;
    case NITRO_BASIC = 3;

    public static function toString(self $premiumTypeToFind): string
    {
        switch($premiumTypeToFind) {
            case self::NONE: return "None";
            case self::NITRO_CLASSIC: return "Nitro Classic";
            case self::NITRO: return "Nitro";
            case self::NITRO_BASIC: return "Nitro Basic";
        }
    }
}