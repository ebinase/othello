<?php

namespace Packages\Domain\Bot;

use Packages\Domain\Bot\Calculators\CalculatorInterface;
use Packages\Domain\Bot\Levels\BotLevel;

interface BotInterface
{
    public function execute(): int;

    public static function getName(): string;
    public static function getDescription(): string;
    public static function getLevelCode(): string;
    public static function getCalculators(): array;

    public function getLevel(): BotLevel;
    public function getCalculator(): CalculatorInterface;
}
