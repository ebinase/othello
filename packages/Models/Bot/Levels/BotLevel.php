<?php

namespace Packages\Models\Bot\Levels;

class BotLevel
{
    public function __construct(
        private string $levelCode,
        private string $name,
        private string $description,
    )
    {}

    /**
     * @return string
     */
    public function getLevelCode(): string
    {
        return $this->levelCode;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
