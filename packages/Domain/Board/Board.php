<?php

namespace Packages\Domain\Board;

use Packages\Domain\Stone\Stone;

class Board
{
    // TODO: arrayable検討
    private $board;
    
    const BOARD_SIZE_X = 8;
    const BOARD_SIZE_Y = 8;

    public function __construct(array $board)
    {
        // 行数チェック
        if (count($board) != self::BOARD_SIZE_Y) {
            throw new \Exception('lack of row');
        }

        // 各行の列数チェック
        foreach ($board as $row) {
            if (count($row) != self::BOARD_SIZE_X) {
                throw new \Exception('lack of column');
            }
        }

        $this->board = $board;
    }


    /**
     * 何も置かれていない場所の数を取得
     *
     * @return void
     */
    public function getRest()
    {
        //
    }

    /**
     * 片方の色の石の数(=得点)を取得
     *
     * @param [type] $color
     * @return void
     */
    public function getScore($color)
    {
        //
    }

    /**
     * 
     *
     * @param [type] $color
     * @return boolean
     */
    public function isPlacable($color)
    {
        //
    }

    public function flipStones(Stone $stone): Board
    {
        // TODO: #6 番兵などでパフォーマンス改善

        $board = $this->board;
        return new Board($board);
    }

    public function equals()
    {
        //
    }
}