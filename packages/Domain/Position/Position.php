<?php

namespace Packages\Domain\Position;

/**
 * 
 */
class Position
{
    private $xSize;
    private $ySize;

    const DEFAULT_SIZE_X = 8;
    const DEFAULT_SIZE_Y = 8;

    private int $x;
    private int $y;

    public function __construct(int $x, int $y, $xSize = self::DEFAULT_SIZE_X, $ySize = self::DEFAULT_SIZE_Y)
    {
        //
    }

    // インデックスでの取得
    public function x(): Position
    {
        // 何かしらの処理
        return $this;
    }

    public function y(): Position
    {
        // 何かしらの処理
        return $this;
    }

    public function index()
    {

    }

    public function first() {
        
    } 

    public function last() {
        
    } 
}