<?php

namespace Packages\Domain\Bot\Calculators;

use Packages\Domain\Turn\Turn;

interface CalculatorInterface
{
    public function __construct(Turn $turn);

    public function culculate(): int;
}
