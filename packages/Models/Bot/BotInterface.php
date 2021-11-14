<?php

namespace Packages\Models\Bot;

use Packages\Models\Board\Position\Position;
use Packages\Models\Bot\Calculators\CalculatorInterface;
use Packages\Models\Bot\Levels\BotLevel;

interface BotInterface
{
    public function execute(): Position;

    public static function getName(): string;
    public static function getDescription(): string;
    public static function getLevelCode(): string;
    public static function getCalculators(): array;

    public function getLevel(): BotLevel;
    public function getCalculator(): CalculatorInterface;
}
