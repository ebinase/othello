<?php

namespace Packages\Domain\Board;

use Packages\Domain\Color\Color;

class FieldList
{
    private array $fieldList;

    public function __construct(array $board)
    {
        
    }

    public function map(array $board)
    {
        foreach ($board as $x => $row) {
            foreach ($row as $y => $status) {
                $fieldList[$x][$y] = app()->make(Field::class, [
                    // Color::isColor($status) ? 
                    // $x, 
                    // $y
                ]);
            }
        }
        return $board;
    }

    public function toArray(): array
    {
        # code...
        return [];
    }
}
