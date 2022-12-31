<?php

namespace CommandString\DiscordOAuth\Users;

/**
 * @see https://discord.com/developers/docs/resources/user#user-object-user-flags
 */
enum Flags: int
{
    case STAFF =                    1 << 0;
    case PARTNER =                  1 << 1;
    case HYPESQUAD =                1 << 2;
    case BUG_HUNTER_LEVEL_1 =       1 << 3;
    case HYPESQUAD_ONLINE_HOUSE_1 = 1 << 6;
    case HYPESQUAD_ONLINE_HOUSE_2 = 1 << 7;
    case HYPESQUAD_ONLINE_HOUSE_3 = 1 << 8;
    case PREMIUM_EARLY_SUPPORTER =  1 << 9;
    case TEAM_PSEUDO_USER =         1 << 10;
    case BUG_HUNTER_LEVEL_2 =       1 << 14;
    case VERIFIED_BOT =             1 << 16;
    case VERIFIED_DEVELOPER =       1 << 17;
    case CERTIFIED_MODERATOR =      1 << 18;
    case BOT_HTTP_INTERACTIONS =    1 << 19;
    case ACTIVE_DEVELOPER =         1 << 22;

    public static function toString(self $flag): string
    {
        switch ($flag) {
            case self::STAFF:                       return "Discord Employee";
            case self::PARTNER:                     return "Partnered Server Owner";
            case self::HYPESQUAD:                   return "Hypesquad Events Member";
            case self::BUG_HUNTER_LEVEL_1:          return "Bug Hunter Level 2";
            case self::HYPESQUAD_ONLINE_HOUSE_1:    return "House Bravery Member";
            case self::HYPESQUAD_ONLINE_HOUSE_2:    return "House Brilliance Member";
            case self::HYPESQUAD_ONLINE_HOUSE_3:    return "House Balance Member";
            case self::PREMIUM_EARLY_SUPPORTER:     return "Early Nitro Supporter";
            case self::TEAM_PSEUDO_USER:            return "Team Owner";
            case self::BUG_HUNTER_LEVEL_2:          return "Bug Hunter Level 2";
            case self::VERIFIED_BOT:                return "Verified Bot";
            case self::VERIFIED_DEVELOPER:          return "Early Verified Bot Developer";
            case self::CERTIFIED_MODERATOR:         return "Certified Moderator";
            case self::BOT_HTTP_INTERACTIONS:       return "HTTP Interactions Only";
            case self::ACTIVE_DEVELOPER:            return "Active Developer";
        }
    }
}