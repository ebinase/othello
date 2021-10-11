<?php

namespace Packages\Domain\Board;

use Packages\Domain\Common\Matrix\Matrix;
use Packages\Domain\Position\Position;
use Packages\Domain\Stone\Stone;

class Board
{
    private Matrix $board;

    const BOARD_EMPTY = 0;

    const BOARD_SIZE_X = 8;
    const BOARD_SIZE_Y = 8;

    public function __construct(array $board)
    {
//        TODO: 色以外の要素があったら全てBOARD_EMPTYで埋める
//        array_map(function ($row) {
//            return ;
//        }, $board);

        $matrix = Matrix::make($board);

        // 行数チェック
        if ($matrix->dim() != self::BOARD_SIZE_Y) throw new \Exception('lack of row');
        // 各行の列数チェック{
        if ($matrix->size() != self::BOARD_SIZE_X) throw new \Exception('lack of column');

        $this->board = $matrix;
    }

    public function toArray(): array
    {
        return $this->board->toArray();
    }

    /**
     * 何も置かれていない場所の数を取得
     *
     * @return int
     */
    public function getRest(): int
    {
        $filterd = array_filter($this->board->flatten(), function ($value) {
            return $value === self::BOARD_EMPTY;
        });

        return count($filterd);
    }

    /**
     * 片方の色の石の数(=得点)を取得
     *
     * @param Color $color
     * @return int
     */
    public function getScore(Color $color): int
    {
        $filterd = array_filter($this->board->flatten(), function ($value) use ($color) {
            return $color->equals($value);
        });

        return count($filterd);
    }

    /**
     *
     *
     * @param Stone $stone
     * @return boolean
     */
    public function isPlayable(Stone $stone): bool
    {
        for ($row = 1; $row < $this->board->dim(); $row++) {
            for ($col = 1; $col < $this->board->size(); $col++) {
                // 一つでもおけるマスがあったらtrueを返す
                if ($this->getFlipCount([$row, $col], $stone) > 0) {
                    return true;
                }
            }
        }
        return false;
    }

    private function getFlipCount(array $position, Stone $stone): int
    {
        $flipCount = 0;

        // 調査するマスが空白ではないときは取れないので0を返す
        $fieldItem = $this->board->getData($position[0], $position[1]);
        if ($fieldItem) {
            return $flipCount;
        }

        $lineDataList = $this->board->getLinesClockwise($position, true);
        foreach ($lineDataList as $lineData) {
            // 何個裏返すことができるか計算
            $lineCount = $this->flipCountInLine($lineData, $stone);
            // 裏返したコマの数を追加
            $flipCount += $lineCount;
        }
        return $flipCount;
    }

    public function update(Position $position, Stone $stone): Board
    {
        // 置けない場合は盤面に変更を加えず返す
        if (!$this->isPlayable($stone)) {
            return $this;
        }
        // 更新された盤面を返す
        $updatedBoard = $this->flipStones($position, $stone);
        return new Board($updatedBoard);
    }

    /**
     * Undocumented function
     *
     * @param array $board
     * @param Stone $stone
     * @return array
     */
    private function flipStones(Position $position, Stone $stone): array
    {
        // TODO: #6 番兵などでパフォーマンス改善

        $board = clone $this->board;
        // HACK: 毎回全要素を取得しているとオーバーヘッドが大きいかもなので、位置だけ取得してデータは必要なときに都度取得する形式の方がいいかも
        $lineDataList = $board->getLinesClockwise($position->toArray(), true);
        $totalCount = 0;
        $updatedLines = [];
        foreach ($lineDataList as $lineData) {
            // 何個裏返すことができるか計算
            $flipCount = $this->flipCountInLine($lineData, $stone);
            if ($flipCount > 0) {
                // 裏返せるコマがあったら裏返す
                for ($i = 0; $i < $flipCount; $i++) {
                    $lineData[$i] = $stone->colorCode();
                }
            }
            $updatedLines[] = $lineData;
            // 裏返したコマの数を追加
            $totalCount += $flipCount;
        }

        if ($totalCount > 0) {
            // ひとつでも裏返せていたらコマを置く
            $board->setData($stone->colorCode(), $position->x(), $position->y());
            $board->setLinesClockwise($updatedLines, $position->toArray(), true);
        }

        return $board->toArray();
    }

    /**
     * Undocumented function
     *
     * @param array $lineData
     * @param Stone $stone
     * @return int $length
     */
    private function flipCountInLine(array $lineData, Stone $stone): int
    {
        if (empty($lineData)) return 0;

        // 添字を初期化(念の為)
        $lineData = array_values($lineData);
        // 反対の色が連続する数を調べる
        $lastKey = 0;
        foreach ($lineData as $key => $field) {
            // 反対の色以外が出たらその位置のキーを記録
            if (!$stone->isOppositeColor($field)) {
                $lastKey = $key;
                break;
            }
        }

        // ループが終了したマスの状態に応じて処理分岐
        if ($stone->colorEquals($lineData[$lastKey])) {
            // 同じ色があったらカウント数を返す
            return $lastKey; // 0の場合も含む
        } else {
            // 何も置いていない or 範囲外に到達した場合はひっくり返すコマは0個
            return 0;
        }
    }

    public function equals(Board $board)
    {
        //
    }

    public function diff(Board $board)
    {
        //
    }
}
