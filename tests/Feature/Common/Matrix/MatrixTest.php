<?php

namespace Tests\Feature\Common\Matrix;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Packages\Domain\Common\Matrix\Matrix;
use Tests\TestCase;

class MatrixTest extends TestCase
{
    public function test_init()
    {
        $this->assertSame($this->getInitBoard(), $this->getInitMatrix()->toArray());
    }

    public function test_getRow()
    {
        $matrix = $this->getInitMatrix();
    }

    public function test_()
    {

    }

    private function getInitMatrix():Matrix
    {
        $matrix = Matrix::init(size: 8, fillWith: 0);
        $matrix->setData('white', 4, 4);
        $matrix->setData('black', 4, 5);
        $matrix->setData('black', 5, 4);
        $matrix->setData('white', 5, 5);

        return $matrix;
    }

    private function getInitBoard()
    {
        static $board = null;
        if (isset($board)) return $board;

        $emptyRow = collect()->pad(8, 0)->toArray();

        // 初期盤面
        $initBoard = [
            $emptyRow,
            $emptyRow,
            $emptyRow,
            collect($emptyRow)->put(3, 'white')->put(4, 'black')->toArray(),
            collect($emptyRow)->put(3, 'black')->put(4, 'white')->toArray(),
            $emptyRow,
            $emptyRow,
            $emptyRow,
        ];

        $board = $initBoard;
        return $board;
    }
}
