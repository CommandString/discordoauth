<?php

namespace CommandString\DiscordOAuth\Enums;

enum ResponseType: string
{
    case TOKEN =    "token";
    case CODE =     "code";
}