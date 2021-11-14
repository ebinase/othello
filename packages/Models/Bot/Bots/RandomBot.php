<?php

namespace Packages\Models\Bot\Bots;

use Packages\Models\Board\Position\Position;
use Packages\Models\Bot\BotInterface;
use Packages\Models\Bot\Calculators\CalculatorInterface;
use Packages\Models\Bot\Calculators\Random\RandomCalculator;
use Packages\Models\Bot\Levels\BotLevel;
use Packages\Models\Bot\Levels\LevelFactory;

class RandomBot implements BotInterface
{
    private static string $name = 'ランダムBot';
    private static string $description = 'ランダムに場所を返すよ';
    private static string $levelCode = LevelFactory::BOT_LEVEL_01;
    private static array  $calculators = [
        RandomCalculator::class
    ];

    /**
     * @param BotLevel $level
     * @param RandomCalculator $randomCalculator
     */
    public function __construct(
        protected BotLevel         $level,
        protected RandomCalculator $randomCalculator,
    )
    {}

    public function execute(): Position
    {
        return $this->randomCalculator->culculate();
    }

    public static function getName(): string
    {
        return self::$name;
    }

    public static function getDescription(): string
    {
        return self::$description;
    }

    public static function getLevelCode(): string
    {
        return self::$levelCode;
    }

    public static function getCalculators(): array
    {
        return self::$calculators;
    }

    public function getLevel(): BotLevel
    {
        return $this->level;
    }

    public function getCalculator(): CalculatorInterface
    {
        return $this->randomCalculator;
    }
}
