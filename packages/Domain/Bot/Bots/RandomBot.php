<?php

namespace Packages\Domain\Bot\Bots;

use Packages\Domain\Bot\BotInterface;
use Packages\Domain\Bot\Calculators\CalculatorInterface;
use Packages\Domain\Bot\Calculators\Random\RandomCalculator;
use Packages\Domain\Bot\Levels\BotLevel;
use Packages\Domain\Bot\Levels\LevelFactory;

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

    public function execute(): int
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
