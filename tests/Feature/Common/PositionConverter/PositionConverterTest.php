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
        assertSame([1,1], $trait->toMatrix(1));
        assertSame([1,2], $trait->toMatrix(2));
        assertSame([1,8], $trait->toMatrix(8));
        assertSame([2,1], $trait->toMatrix(9));
        assertSame([8,8], $trait->toMatrix(64));
        // エラー系
        assertSame(null, $trait->toMatrix(0));
        assertSame(null, $trait->toMatrix(65));
    }

    public function testToId()
    {
        $trait = new class {
            use PositionConverterTrait;
        };
        assertSame(1, $trait->toId([1,1]));
        assertSame(2, $trait->toId([1,2]));
        assertSame(8, $trait->toId([1,8]));
        assertSame(9, $trait->toId([2,1]));
        assertSame(64, $trait->toId([8,8]));
        // エラー系
        assertSame(null, $trait->toId([0,0]));
        assertSame(null, $trait->toId([8,9]));
        assertSame(null, $trait->toId([9,8]));
    }
}
