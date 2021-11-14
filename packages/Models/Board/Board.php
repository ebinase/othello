<?php

namespace Packages\Models\Board;

use Packages\Models\Board\Color\Color;
use Packages\Models\Board\Position\Position;
use Packages\Models\Board\Position\PositionConverterTrait;
use Packages\Models\Common\Matrix\Matrix;

class Board
{
    use PositionConverterTrait;

    /**
     * @var Matrix
     */
    private Matrix $board;

    /**
     * @var array<int, int>
     */
    private array $flipScores;

    const BOARD_EMPTY = 0;

    const BOARD_SIZE_ROWS = 8;
    const BOARD_SIZE_COLS = 8;

    private function __construct(array $board)
    {
        $matrix = Matrix::make($board);

        // 行数チェック
        if ($matrix->dim() != self::BOARD_SIZE_ROWS) throw new \RuntimeException('lack of row');
        // 各行の列数チェック
        if ($matrix->size() != self::BOARD_SIZE_COLS) throw new \RuntimeException('lack of column');

        $this->board = $matrix;
    }

    public static function init(): Board
    {
        $matrix = Matrix::init(self::BOARD_SIZE_COLS, self::BOARD_SIZE_ROWS, self::BOARD_EMPTY);
        $matrix->setData(Color::white()->toCode(), 4, 4);
        $matrix->setData(Color::black()->toCode(), 4, 5);
        $matrix->setData(Color::black()->toCode(), 5, 4);
        $matrix->setData(Color::white()->toCode(), 5, 5);

        return new Board($matrix->toArray());
    }

    public static function make(array $board): Board
    {
        return new Board($board);
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
    public function getPoint(Color $color): int
    {
        $filterd = array_filter($this->board->flatten(), function ($value) use ($color) {
            return $color->codeEquals($value);
        });

        return count($filterd);
    }

    /**
     *
     *
     * @param Color $color
     * @return bool
     */
    public function hasPlayablePosition(Color $color): bool
    {
        for ($row = 1; $row <= $this->board->dim(); $row++) {
            for ($col = 1; $col <= $this->board->size(); $col++) {
                // 一つでもおけるマスがあったらtrueを返す
                if ($this->isValid(Position::make([$row, $col]), $color)) return true;
            }
        }
        return false;
    }

    /**
     * @param Color $color
     * @return array
     */
    public function playablePositions(Color $color): array
    {
        if (empty($this->flipScores)) $this->analyze($color);

        return array_keys($this->flipScores); // ひっくり返せる場所のidだけ返す
    }

    private function getFlipScore(array $position, Color $color): int
    {
        $flipScore = 0;

        // 調査するマスが空白ではないときは取れないので0を返す
        $fieldItem = $this->board->getData($position[0], $position[1]);
        if ($fieldItem) {
            return $flipScore;
        }

        $lineDataList = $this->board->getLinesClockwise($position, true);
        foreach ($lineDataList as $lineData) {
            // 何個裏返すことができるか計算
            $lineCount = $this->flipCountInLine($lineData, $color);
            // 裏返したコマの数を追加
            $flipScore += $lineCount;
        }
        return $flipScore;
    }

    public function isValid(Position $position, Color $color): bool
    {
        if ($this->getFlipScore($position->toMatrixPosition(), $color) > 0) {
            return true;
        }
        return false;
    }

    public function update(Position $position, Color $color): Board
    {
        // 置けない場合
        if (!$this->isValid($position, $color)) {
            throw new \Exception();
        }

        // 更新された盤面を返す
        $updatedBoard = $this->flipStones($position->toMatrixPosition(), $color);
        return new Board($updatedBoard);
    }

    /**
     * Undocumented function
     *
     * @param array $board
     * @param Color $color
     * @return array
     */
    private function flipStones(array $position, Color $color): array
    {
        // TODO: #6 番兵などでパフォーマンス改善

        $board = clone $this->board;
        // HACK: 毎回全要素を取得しているとオーバーヘッドが大きいかもなので、位置だけ取得してデータは必要なときに都度取得する形式の方がいいかも
        $lineDataList = $board->getLinesClockwise($position, true);
        $totalCount = 0;
        $updatedLines = [];
        foreach ($lineDataList as $lineData) {
            // 何個裏返すことができるか計算
            $flipCount = $this->flipCountInLine($lineData, $color);
            if ($flipCount > 0) {
                // 裏返せるコマがあったら裏返す
                for ($i = 0; $i < $flipCount; $i++) {
                    $lineData[$i] = $color->toCode();
                }
            }
            $updatedLines[] = $lineData;
            // 裏返したコマの数を追加
            $totalCount += $flipCount;
        }

        if ($totalCount > 0) {
            // ひとつでも裏返せていたらコマを置く
            $board->setData($color->toCode(), $position[0], $position[1]);
            $board->setLinesClockwise($updatedLines, $position, true);
        }

        return $board->toArray();
    }

    /**
     * Undocumented function
     *
     * @param array $lineData
     * @param Color $color
     * @return int $length
     */
    private function flipCountInLine(array $lineData, Color $color): int
    {
        if (empty($lineData)) return 0;

        // 添字を初期化(念の為)
        $lineData = array_values($lineData);
        // 反対の色が連続する数を調べる
        $lastKey = 0;
        foreach ($lineData as $key => $field) {
            // 反対の色以外が出たらその位置のキーを記録
            if (!$color->isOppositeCode($field)) {
                $lastKey = $key;
                break;
            }
        }

        // ループが終了したマスの状態に応じて処理分岐
        if ($color->codeEquals($lineData[$lastKey])) {
            // 同じ色があったらカウント数を返す
            return $lastKey; // 0の場合も含む
        } else {
            // 何も置いていない or 範囲外に到達した場合はひっくり返すコマは0個
            return 0;
        }
    }

    public function equals(Board $board): bool
    {
        return $this->board->toArray() === $board->toArray();
    }

    public function diff(Board $board)
    {
        //
    }

    public function analyze(Color $color)
    {
        $flipScores = [];
        for ($row = 1; $row <= $this->board->dim(); $row++) {
            for ($col = 1; $col <= $this->board->size(); $col++) {
                $score = $this->getFlipScore([$row, $col], $color);
                if ($score > 0) {
                    $positionId = $this->convertToPositionId([$row, $col]);
                    $flipScores[$positionId] = $score;
                }
            }
        }

        $this->flipScores = $flipScores;
    }
}
