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
        self::assertSame($this->getZeroFillArray(), Matrix::init(size: 4, fillWith: 0)->toArray());
    }

    public function test_make()
    {
        $matrix = Matrix::make($this->getArrayOfId());
        self::assertSame($this->getArrayOfId(), $matrix());
    }

    public function test_getRow()
    {
        $matrix = Matrix::make($this->getArrayOfId());

        $this->assertSame([31, 32, 33, 34], $matrix->getRow(3));
        $this->assertSame([31, 32, 33, 34], $matrix->getRow([3, 9999]));
        // splitかつ片方が空配列
        $this->assertSame([[], [33, 32, 31]], $matrix->getRow([3, 4], true));
    }

    public function test_getCol()
    {
        $matrix = Matrix::make($this->getArrayOfId());
        $this->assertSame([13, 23, 33, 43], $matrix->getCol(3));
        $this->assertSame([13, 23, 33, 43], $matrix->getCol([9999, 3]));
        // splitかつ片方が空配列
        $this->assertSame([[], [33, 23, 13]], $matrix->getCol([4, 3], true));
    }

    public function test_getDiagUp()
    {
        $matrix = Matrix::make($this->getArrayOfId());
        $this->assertSame([41, 32, 23, 14], $matrix->getDiagUp([2, 3]));
        // split(前半２つが反転する場所)
        $this->assertSame([[14], [32, 41]], $matrix->getDiagUp([2, 3], true));
        $this->assertSame([[], []], $matrix->getDiagUp([1, 1], true));
    }

    public function test_getDiagDown()
    {
        $matrix = Matrix::make($this->getArrayOfId());
        $this->assertSame([11, 22, 33, 44], $matrix->getDiagDown([3, 3]));
        // split(前半２つが反転する場所)
        $this->assertSame([[44], [22, 11]], $matrix->getDiagDown([3, 3], true));
        $this->assertSame([[], []], $matrix->getDiagDown([1, 4], true));
    }


//    public function test_()
//    {
//
//    }

    private function getZeroFillArray()
    {
        $emptyRow = collect()->pad(4, 0);
        return collect()->pad(4, $emptyRow)->toArray(); //再帰的に配列化
    }

    private function getArrayOfId()
    {
        $emptyArray = $this->getZeroFillArray();
        foreach ($emptyArray as $row => $emptyRow) {
            foreach ($emptyRow as $col => $item) {
                $ret[$row][$col] = ($row+1)* 10 + ($col+1); //1スタートの値に直してから数値に変換する(1,3) => 13
            }
        }
        return $ret;
    }
}
