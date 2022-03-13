<?php

namespace Packages\Models\Bot\Calculators;

use Packages\Models\Board\Position\Position;
use Packages\Models\Turn\Turn;

interface CalculatorInterface
{
    public static function culculate(Turn $turn): Position;
}
