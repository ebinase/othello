<?php

namespace Packages\Domain\Skip;

class SkipCount
{
    private int $count;

    public function __construct(int $count = 0)
    {
        $this->count = $count;
    }

    /**
     * 現在のスキップ数を取得する
     *
     * @return void
     */
    public function getCurrentCount()
    {

    }

    /**
     * カウントアップしたオブジェクトを返す
     *
     * @return $this
     */
    public function countUp()
    {
        
    }
}