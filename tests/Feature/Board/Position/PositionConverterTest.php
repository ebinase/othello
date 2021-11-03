<?php

namespace Tests\Feature\Board\Position;

use Packages\Domain\Board\Position\PositionConverterTrait;
use Tests\TestCase;
use function PHPUnit\Framework\assertSame;

class PositionConverterTest extends TestCase
{
    public function testToMatrix()
    {
        $trait = new class {
            use PositionConverterTrait;
        };
        assertSame([1,1], $trait->convertToMatrixPosition(1));
        assertSame([1,2], $trait->convertToMatrixPosition(2));
        assertSame([1,8], $trait->convertToMatrixPosition(8));
        assertSame([2,1], $trait->convertToMatrixPosition(9));
        assertSame([8,8], $trait->convertToMatrixPosition(64));
        // エラー系
        assertSame(null, $trait->convertToMatrixPosition(0));
        assertSame(null, $trait->convertToMatrixPosition(65));
    }

    public function testToId()
    {
        $trait = new class {
            use PositionConverterTrait;
        };
        assertSame(1, $trait->convertToPositionId([1,1]));
        assertSame(2, $trait->convertToPositionId([1,2]));
        assertSame(8, $trait->convertToPositionId([1,8]));
        assertSame(9, $trait->convertToPositionId([2,1]));
        assertSame(64, $trait->convertToPositionId([8,8]));
        // エラー系
        assertSame(null, $trait->convertToPositionId([0,0]));
        assertSame(null, $trait->convertToPositionId([8,9]));
        assertSame(null, $trait->convertToPositionId([9,8]));
    }
}
