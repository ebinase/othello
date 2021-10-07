<?php

namespace Packages\Domain\Common\Matrix;

use http\Exception\InvalidArgumentException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\Pure;

/**
 * phpの配列とnumpyの中間のような形で配列をラッピングして扱えるようにするクラス
 *
 * 配列のキーの始めの値や配列のサイズなどの概念・用語を統一する。
 * また、配列の任意の要素やその要素の周囲の要素を直線的に取得する機能も提供する
 * HACK: 車輪の再発明感が否めない。。。数学的な行列計算に振り切って、https://github.com/markrogoyski/math-phpを利用してもいいかも
 */
class Matrix implements MatrixInterface
{
    private array $container;

    const OOR = '_out_of_range';

    // 原点
    private $origin = 1;
    private $emptySign;

    /**
     * シングルトンで実装
     * @param array $data
     * @param $emptySign
     */
    protected function __construct(array $data, $emptySign  = null)
    {
        $this->container = $data;
        $this->emptySign = $emptySign;
    }

    public static function make(array $data): self
    {
        // 配列からインスタンス作成
        return new Matrix($data);
    }

    public static function init(int $size, int $dim = null, $fillWith = null): self
    {
        // 1行分のデータ作成
        $row = collect()->pad($size, $fillWith);

        if (isset($dim)) {
            // 次元(行数)の指定があった場合は指定されたサイズで多次元配列作成
            $data = collect()->pad($dim, $row);
        } else {
            // 指定がなければ正方行列を作成
            $data = collect()->pad($size, $row);
        }
        // 配列化してからインスタンス化
        return new Matrix($data->toArray(), $fillWith);
    }

    public function changeOrigin(int $origin)
    {
        $this->origin = $origin;
    }

    public function setData($data, int $row, int $col): void
    {
        // TODO: 範囲チェック
        list($row, $col) = $this->convert([$row, $col]);
        $this->container[$row][$col] = $data;
    }

    public function getData(int $row, int $col): mixed
    {
        // TODO: 範囲チェック
        list($row, $col) = $this->convert([$row, $col]);
        return $this->container[$row][$col] ?? null;
    }

    public function toArray(): array
    {
        // TODO: データ形式に応じた変換処理実装
        return $this->container;
    }

    // TODO: 座標系の原点の位置やベクトルの正負の向き、「行・列の番号とindexes」などの概念を統一する

    public function getRow(array|int $position, bool $split = false): array
    {
        // 引数が配列だった場合、要素数をチェック
        if (is_array($position) && count($position) !== 2) throw new InvalidArgumentException();

        if ($split === false) {
            // 行番号を取り出す
            $row = is_int($position) ? $this->index($position) : $this->index($position[0]);
            return $this->container[$row] ?? [];
        }

        $base = $this->convert($position);
        $vector = [0, 1];
        return $this->getLineAll($base, $vector, $split);
    }

    public function getCol(array|int $position, bool $split = false): array
    {
        // 引数が配列だった場合、要素数をチェック
        if (is_array($position) && count($position) !== 2) throw new InvalidArgumentException();

        if ($split === false) {
            // 列番号を取り出す
            $col = is_int($position) ? $this->index($position) : $this->index($position[1]);
            return collect($this->container)->pluck($col)->toArray();
        }

        $base = $this->convert($position);
        $vector = [1, 0];
        return $this->getLineAll($base, $vector, $split);
    }

    /**
     * @param array $position
     * @param bool $split
     * @return array[]
     */
    public function getDiagUp(array $position, bool $split = false): array
    {
        $base = $this->convert($position);
        $vector = [-1, 1];
        // 左下から右上に向かう方向(-->>) or 左上と右下に向かう方向(<-->)
        return $this->getLineAll($base, $vector, $split);
    }

    public function getDiagDown(array $position, bool $split = false): array
    {
        $base = $this->convert($position);
        $vector = [1, 1];
        // 左上から右下に向かう方向(-->>) or 左上と右下に向かう方向(<-->)
        return $this->getLineAll($base, $vector, $split);

    }

    public function getLineAll(array $base, array $vector, bool $split = false): array
    {
        // ベクトルの方向
        $vectorDir = $this->getOneWayLine($base, $vector);
        // 逆ベクトルの方向
        $inverseDir  = $this->getOneWayLine($base, $this->inverse($vector));

        if ($split) {
            return [$vectorDir, $inverseDir]; // 指定された場所から外側に向かう方向(<-->)
        } else {
            return array_merge(
                array_reverse($inverseDir), [$this->get($base)], $vectorDir // ベクトルの向かう方向(-->>)
            );
        }
    }


    /**
     * @param int[] $indexes インデックス形式(0スタート)の座標
     * @param int[] $vector 進行方向のベクトル
     * @param int|null $limit 取得する要素数
     * @return array
     */
    private function getOneWayLine(array $indexes, array $vector, ?int $limit = null): array
    {
        // 隣のマスに移動
        $indexes = $this->move($indexes, $vector);

        $lineData = [];
        $count = 1;
        while ($this->isValid($indexes)) { // 厳密に配列の範囲外を取得した場合のみループを抜ける
            $lineData[] = $this->get($indexes);
            $indexes = $this->move($indexes , $vector);
            // limitのチェック
            if (isset($limit) && $count <= $limit) break;
            // limitに問題がなければ次のマスへ
            $count++;
        }

        return $lineData;
    }

    /**
     * @param int[] $indexes インデックス形式(0スタート)の座標
     * @param int[] $vector
     * @param int $steps
     * @return array
     */
    private function move(array $indexes, array $vector, int $steps = 1): array
    {
        // 指定されたステップ分だけ進む
        $row = $indexes[0] + $vector[0] * $steps;
        $col = $indexes[1] + $vector[1] * $steps;
        return [$row, $col];
    }

    public function getAllDirection(array $position, bool $split = false): array
    {
        // TODO: Implement getAllDirection() method.
    }

    public function fill($value): MatrixInterface
    {
        // TODO: Implement fill() method.
    }

    public function flat($offset): MatrixInterface
    {
        // TODO: Implement flat() method.
    }

    public function shape(): array
    {
        // TODO: Implement shape() method.
    }


    public function size(): int
    {
        // TODO: Implement size() method.
    }

    public function dim(): int
    {
        // TODO: Implement dim() method.
    }

    private function inverse(array $vector): array
    {
        return array_map(function ($value) {return $value*(-1);}, $vector);
    }

    private function index($num): int
    {
        return $num - $this->origin;
    }

    /**
     * @param int[] $nums
     * @return array
     */
    private function convert(array $nums): array
    {
        return array_map(function ($num) {
            return $this->index($num);
            }, $nums
        );
    }

    // 内部処理用getter/setter

    private function get(array $indexes)
    {
        // TODO: 独自の例外を投げるようにする
        return $this->container[$indexes[0]][$indexes[1]];
    }

    private function set($value, array $indexes)
    {
        $this->container[$indexes[0]][$indexes[1]] = $value;
    }

    private function isValid($indexes): bool
    {
        // コンテナにnullが設定されていた場合も考慮し、範囲外を参照したときのみfalseを返す
        try {
            $this->get($indexes);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function __invoke(): array
    {
        return $this->toArray();
    }
}
