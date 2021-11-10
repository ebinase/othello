<?php

namespace Packages\Models\Bot;

use Packages\Models\Bot\Calculators\CalculatorInterface;
use Packages\Models\Bot\Levels\LevelFactory;
use Packages\Models\Turn\Turn;

class BotFactory
{
    const BOT_ID_RANDOM = '01';

    /**
     * @var array<string, CalculatorInterface>
     */
    private static array $botList = [
        self::BOT_ID_RANDOM => \Packages\Domain\Bot\Bots\RandomBot::class
    ];

    public static function make(string $botId, Turn $turn): BotInterface
    {
        $calculators = [];

        $botClass = self::$botList[$botId];
        $level = LevelFactory::make($botClass::getLevelCode());
        foreach ($botClass::getCalculators() as $calculatorClass) {
            $calculators[] = new $calculatorClass($turn);
        }

        return new $botClass($level, $calculators[0]);
    }

}
