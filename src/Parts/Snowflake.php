<?php

namespace CommandString\DiscordOAuth\Parts;

class Snowflake {
    public function __construct(public readonly int $snowflake) {}

    public function getTimestamp(): int
    {
        return floor((($this->snowflake >> 22) + 1420070400000) / 1000);
    }

    public function getInternalWorkerId(): int
    {
        return ($this->snowflake & 0x3E0000) >> 17;
    }

    public function getInternalProcessId(): int
    {
        return ($this->snowflake & 0x1F000) >> 12;
    }

    public function getIncrement(): int
    {
        return $this->snowflake & 0xFFF;
    }

    public function __toString()
    {
        return $this->snowflake;
    }
}