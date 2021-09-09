<?php

namespace Packages\Domain\Turn;

class TurnNumber
{
    private int $turnNumber;

    public function __construct(int $turnNumber = 0)
    {
        $this->turnNumber = $turnNumber;
    }

    /**
     * 現在のスキップ数を取得する
     *
     * @return void
     */
    public function getCurrent()
    {
        return $this->turnNumber;
    }

    /**
     * カウントアップしたオブジェクトを返す
     *
     * @return $this
     */
    public function countUp()
    {
        //   
    }
}