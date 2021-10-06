<?php

namespace Packages\Domain\Common\Matrix;

use http\Exception\InvalidArgumentException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Matrix implements MatrixInterface
{
    private array $container;

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

    public static function make(array ...$arrayList): self
    {
        // 多次元配列のコレクションからインスタンス作成
        return new Matrix($arrayList);
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
        list($row, $col) = $this->convert($row, $col);
        $this->container[$row][$col] = $data;
    }

    public function getData(int $row, int $col): mixed
    {
        // TODO: 範囲チェック
        list($row, $col) = $this->convert($row, $col);
        return $this->container[$row][$col] ?? null;
    }

    public function toArray(): array
    {
        return $this->container;
    }

    public function getRow(array|int $pos, bool $split = false): array
    {
        if (is_int($pos)) {
            $row = $pos;
            return Arr::get($this->container, $this->convert($row), []);
        }

        // このあとが少し冗長になるが、ここで引数の配列の要素数をチェック
        if (count($pos) !== 2) throw new InvalidArgumentException();
        list($row, $col) = $this->convert($pos[0], $pos[1]);

        $rowData = Arr::get($this->container, $row, []);

        if ($split === false) {
            return $rowData;
        }

        // TODO: split実装
//        $splited = collect($rowData)->chunkWhile(function ($value, $key, $chunk) use ($col) {
//            return $key !== $col;
//        });

        return [];
    }

    public function getCol(array|int $pos, bool $split = false): array
    {
        // 列番号のみ指定された場合($splitは無視)
        if (is_int($pos)) {
            $col = $this->convert($pos);
            return collect($this->container)->pluck($col)->toArray();
        }

        // 引数が配列だった場合、要素数をチェック
        if (count($pos) !== 2) throw new InvalidArgumentException();
        list($row, $col) = $pos;

        $colData = collect($this->container)->pluck($col)->toArray();

        if ($split === false) {
            return $colData;
        }
        // TODO: split実装
        return [];
    }

    public function getDiagUp(array $position, bool $split = false): array
    {
        // TODO: Implement getDiagDown() method.
    }

    public function getDiagDown(array $pos, bool $split = false): array
    {
        // TODO: Implement getDiagDown() method.
    }

    public function getAllDirection(array $pos, bool $split = false): array
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

    private function index($num): int
    {
        return $num - $this->origin;
    }

    private function convert(int ...$nums): array
    {
        return array_map(function ($num) {
            return $this->index($num);
            }, $nums
        );
    }
}
