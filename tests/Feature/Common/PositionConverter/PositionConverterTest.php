<?php

namespace Tests\Feature\Common\PositionConverter;

use Packages\Domain\Common\Position\PositionConverterTrait;
use Tests\TestCase;
use function PHPUnit\Framework\assertSame;

class PositionConverterTest extends TestCase
{
    public function testToMatrix()
    {
        $trait = new class {
            use PositionConverterTrait;
        };
        assertSame([1,1], $trait->toMatrixPosition(1));
        assertSame([1,2], $trait->toMatrixPosition(2));
        assertSame([1,8], $trait->toMatrixPosition(8));
        assertSame([2,1], $trait->toMatrixPosition(9));
        assertSame([8,8], $trait->toMatrixPosition(64));
        // エラー系
        assertSame(null, $trait->toMatrixPosition(0));
        assertSame(null, $trait->toMatrixPosition(65));
    }

    public function testToId()
    {
        $trait = new class {
            use PositionConverterTrait;
        };
        assertSame(1, $trait->toPositionId([1,1]));
        assertSame(2, $trait->toPositionId([1,2]));
        assertSame(8, $trait->toPositionId([1,8]));
        assertSame(9, $trait->toPositionId([2,1]));
        assertSame(64, $trait->toPositionId([8,8]));
        // エラー系
        assertSame(null, $trait->toPositionId([0,0]));
        assertSame(null, $trait->toPositionId([8,9]));
        assertSame(null, $trait->toPositionId([9,8]));
    }
}
