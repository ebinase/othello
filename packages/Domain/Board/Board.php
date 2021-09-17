<?php

namespace Packages\Domain\Board;

use Packages\Domain\Stone\Stone;
use Packages\Domain\Position\Position;
use Packages\Domain\Common\Definitions\PositionDefine;

class Board
{
    // TODO: arrayable or Stoneのファーストクラスコレクション化を検討
    private $board;

    const BOARD_STATUS_EMPTY = 0;
    const BOARD_STATUS_PLACED = 0;
    // const BOARD_STATUS_BLACK = 1;
    // const BOARD_STATUS_WHITE = 2;
    
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

        $this->board = $this->map($board);
    }

    public function map($board)
    {
        foreach ($board as $x => $row) {
            foreach ($row as $y => $color) {
                $board[$x][$y] = !empty($color) ? new Stone($color, new Position($x, $y)) : self::BOARD_STATUS_EMPTY;
            }
        }
        return $board;
    }

    public function toArray(): array
    {
        // TODO: 配列に変換する処理
        return $this->board;
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
    public function isPlayable($color)
    {
        //
    }

    public function update(Stone $stone): Board
    {
        $updatedBoard = $this->flipStones($this->board, $stone);;
        return new Board($updatedBoard);
    }

    private function flipStones(array $board, Stone $stone): array
    {
        // TODO: #6 番兵などでパフォーマンス改善
        
        foreach(PositionDefine::directions as $direction) {
            // 何個裏返すことができるか計算
            $flipCount = $this->flipCountInLine($board, $stone, $direction);
            // 裏返せるコマの位置を取得しひとつひとつ裏返す
            foreach ($stone->positionsInMove($flipCount, $direction) as $postion) {
                $board = $this->flip($board, $postion, $stone->colorCode());
            }
        }

        return $board;
    }

    /**
     * Undocumented function
     *
     * @param array $board
     * @param Stone $stone
     * @param array $direction
     * @return array $length
     */
    public function flipCountInLine($board, $stone, $direction)
    {
        $count = 0;
        // 隣のマスへ移動
        $x = $stone->x() + $direction['x'];
        $y = $stone->y() + $direction['y'];

        // 反対の色が連続する数を調べる
        while ($board[$x][$y] === $stone->colorCode()->opposite()) {
            $count++;
            // 次のマスへ
            $x += $direction['x'];
            $y += $direction['y'];
        }
        
        // ループが終了したマスの状態に応じて処理分岐
        if ($stone->colorCode()) {
            // 同じ色があったらカウント数を返す
            return $count;
        } else {
            // 何も置いていない or 範囲外に到達した場合はひっくり返すコマは0個
            return 0;   
        }
    }

    private function flip($board, $position, $colorCode)
    {
        // TODO: 色チェックと引数をオブジェクトにするのかの確認
        return $board[$position['x']][$position['y']] = $colorCode;
    }

    public function equals()
    {
        //
    }
}