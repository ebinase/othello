<?php

namespace Packages\Domain\Position;

/**
 * 
 */
class Position
{
    private int $x;
    private int $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function toArray()
    {
        return ['x' => $this->x, 'y' => $this->y];
    }

    // インデックスでの取得
    public function x()
    {
        return $this->x;
    }

    public function y()
    {
        // 何かしらの処理
        return $this->y;
    }

    /**
     * 方向を指定して直線的に移動した先の座標を返す
     *
     * @param  int $step
     * @param  array $direction
     * @return Position
     */
    public function move($step, $direction): Position
    {
        // 進行方向を取得
        list($xDir, $yDir) = $direction;
        // 指定されたステップ分だけ進む
        $x = $this->x + $step * $xDir;
        $y = $this->y + $step * $yDir;
        return new Position($x, $y);
    }

    public function positionsInMove($step, $direction): array
    {
        $posions = [];
        for ($i=1; $i <= $step; $i++) { 
            $posions[] = $this->move($i, $direction);
        }
        return $posions;
    }

    /**
     * 自身の場所から移動する間にある座標をすべて返す
     *
     * @param  int $step
     * @param  array $direction
     * @param  array $containsEdge 目的地の座標も含めるかどうか
     * @return Position
     */
    public function checkPoints(Position $goal)
    {
        
        // return new Position($x, $y);
    }

    public function diff(Position $position)
    {
        
    }
}