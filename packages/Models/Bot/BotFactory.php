<?php

namespace Packages\Models\Bot;

use Packages\Models\Bot\Bots\RandomBot;
use Packages\Models\Bot\Bots\SingleOpennessBot;

class BotFactory
{
    public static function make(BotType $botType): BotInterface
    {
        $botClass = match ($botType) {
            BotType::RANDOM => RandomBot::class,
            BotType::SINGLE_OPENNESS => SingleOpennessBot::class
        };

        return new $botClass;
    }
}
