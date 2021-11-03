<?php

namespace Packages\Models\Bot;

use Packages\Models\Bot\Calculators\CalculatorInterface;

class BotList
{
    public static function botInfo()
    {

    }

    /**
     * @return string[]
     */
    public static function getBotNameList(): array
    {
        $result = [];
        foreach (self::$botList as $key => $botClass) {
            $result[$key] = $botClass::getName();
        }

        return $result;
    }

    /**
     * @param $botId
     * @return CalculatorInterface
     */
    public static function getBotStrategy($botId): CalculatorInterface
    {
        return self::$botStrategyList[$botId];
    }
}
