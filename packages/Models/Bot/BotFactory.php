<?php

namespace Packages\Models\Bot;

use Packages\Models\Bot\Calculators\CalculatorInterface;
use Packages\Models\Bot\Levels\LevelFactory;
use Packages\Models\Turn\Turn;

class BotFactory
{
    const BOT_ID_RANDOM = '01';

    /**
     * @var array<string, BotInterface>
     */
    private static array $botList = [
        self::BOT_ID_RANDOM => \Packages\Models\Bot\Bots\RandomBot::class
    ];

    public static function make(string $botId): BotInterface
    {
        $botClass = self::$botList[$botId];

        return app()->make($botClass, ['id' => $botId]);
    }

}
