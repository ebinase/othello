<?php

namespace Packages\Domain\Common\Matrix;

use Illuminate\Support\Collection;

class Matrix implements MatrixInterface
{
    private Collection $container;

    // 原点
    private $origin = 1;

    /**
     * シングルトンで実装
     * @param Collection $data
     */
    protected function __construct(Collection $data)
    {
        $this->container = $data;
    }

    public static function make(array ...$arrayList): self
    {
        $data = [];
        // 初期化
        foreach ($arrayList as $array) {
            // 行データをもとに多次元配列作成
            $data[] = collect($array);
        }
        // 多次元配列のコレクションからインスタンス作成
        return new Matrix(collect($data));
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
        // コレクションからインスタンス化
        return new Matrix($data);
    }

    public function changeOrigin(int $origin)
    {
        $this->origin = $origin;
    }

    public function setData($data, int $row, int $col)
    {
        list($row, $col) = $this->convert($row, $col);
        /**@var Collection $rowData*/
        $rowData = $this->container->get($row);
        // 行データを変更して上書き
        $this->container->put($row, $rowData->put($col, $data));
    }

    public function getData(int $row, int $col)
    {
        list($row, $col) = $this->convert($row, $col);
        /**@var Collection $rowData*/
        $rowData = $this->container->get($row);
        return $rowData->get($col);
    }

    public function toArray(): array
    {
        return $this->container->toArray();
    }


    public function getRow($rowNum)
    {
        // TODO: Implement getRow() method.
    }

    public function getCol($colNum)
    {
        // TODO: Implement getCol() method.
    }

    public function getDiag($rowNum, $colNum)
    {
        // TODO: Implement getDiag() method.
    }

    public function getLine($direction, $oneWay)
    {
        // TODO: Implement getLine() method.
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
