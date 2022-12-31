<?php

namespace CommandString\DiscordOAuth\Users;

use CommandString\DiscordOAuth\Enums\Endpoints;
use CommandString\DiscordOAuth\OAuth;
use CommandString\DiscordOAuth\Parts\Snowflake;
use React\Http\Browser;

use function React\Async\await;

/**
 * @see https://discord.com/developers/docs/resources/user#user-object
 */
class User {
    public readonly Snowflake $id_snowflake;

    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly string $discriminator,
        public readonly ?string $avatar = null,
        public readonly ?bool $bot = null,
        public readonly ?bool $system = null,
        public readonly ?bool $mfa_enabled = null,
        public readonly ?string $banner = null,
        public readonly ?int $accent_color = null,
        public readonly ?string $locale = null,
        public readonly ?string $email = null,
        public readonly int $flags,
        public readonly int $premium_type,
        public readonly int $public_flags
    ) {
        $this->id_snowflake = new Snowflake($id);
    }

    public static function getWithToken(string $tokenType, string $token, ?Browser $browser = null): self
    {
        if (is_null($browser)) {
            $browser = new \React\Http\Browser();
        }

        $res = await($browser->get(Endpoints::buildEndpointUrl("/users/@me"), [
            "authorization" => "{$tokenType} {$token}"
        ]));

        $json = json_decode($res->getBody());

        $keys = ["id", "username", "discriminator", "avatar", "bot", "system", "mfa_enabled", "banner", "accent_color", "locale", "email", "flags", "premium_type", "public_flags"];

        $args = [];

        foreach ($keys as $key) {
            if (!isset($json->$key) || is_null($json->$key)) {
                $args[$key] = null;
                continue;
            }

            if ($key === "id") {
                $json->$key = (int)$json->$key;
            }

            $args[$key] = $json->$key;
        }

        return new self(...$args);
    }

    /**
     * @return Flags[]
     */
    public function getFlags(): array
    {
        $flags = [];

        foreach (Flags::cases() as $flag) {
            if (($this->flags & $flag->value) === $flag->value) {
                $flags[] = $flag;
            }
        }

        return $flags;
    }
    
    /**
     * @return Flags[]
     */
    public function getPublicFlags(): array
    {
        $flags = [];

        foreach (Flags::cases() as $flag) {
            if (($this->public_flags & $flag->value) === $flag->value) {
                $flags[] = $flag;
            }
        }

        return $flags;
    }
    
    public function getPremiumType(): PremiumTypes
    {
        foreach (PremiumTypes::cases() as $type) {
            if ($this->premium_type === $type->value) {
                return $type;
            }
        }
    }

    public function getAvatarUrl(): string
    {
        return "https://cdn.discordapp.com/avatars/{$this->id}/{$this->avatar}.png";
    }

    public function getAccentHex(): string
    {
        return dechex($this->accent_color);
    }
}