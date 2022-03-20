<?php

namespace Packages\Models\Bot;

use Packages\Models\Bot\Bots\RandomBot;
use Packages\Models\Bot\Bots\SelfOpennessBot;

class BotFactory
{
    public static function make(BotType $botType): BotInterface
    {
        $botClass = match ($botType) {
            BotType::RANDOM => RandomBot::class,
            BotType::SELF_OPENNESS => SelfOpennessBot::class
        };

        return new $botClass;
    }
}
