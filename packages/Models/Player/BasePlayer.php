<?php

namespace Packages\Models\Player;

class BasePlayer implements PlayerInterface
{
    private string $id;
    private string $name;
    private string $type;

    public function __construct($id, $name, $type)
    {
        $this->id   = $id;
        $this->type = $type;
        $this->name = $name;
    }

    public function getid(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPlayerType(): string
    {
        return $this->type;
    }

    public function isBot(): bool
    {
        return  str_starts_with($this->type, self::PLAYER_TYPE_PREFIX_BOT);
    }

    public function isPerson(): bool
    {
        return  str_starts_with($this->type, self::PLAYER_TYPE_PREFIX_PERSON);
    }
}
