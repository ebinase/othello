<?php

namespace Tests\Feature\Board\Position;

use Packages\Domain\Board\Position\Position;
use Tests\TestCase;

class PositionTest extends TestCase
{
    public function test座標idを渡した場合の相互変換()
    {
        // given:
        $positionId = 64; // 8行8列目, id=64
        // when:
        $position = Position::make($positionId);
        // then:
        self::assertSame(64, $position->toPostionId());
        self::assertSame([8, 8], $position->toMatrixPosition());
    }

    public function test行と列を渡した場合の相互変換()
    {
        // given:
        $matrixPosition = [8, 8]; // 8行8列目, id=64
        // when:
        $position = Position::make($matrixPosition);
        // then:
        self::assertSame(64, $position->toPostionId());
        self::assertSame([8, 8], $position->toMatrixPosition());
    }
}
