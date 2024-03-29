<?php

namespace Packages\Models\Common\Matrix;

/**
 * numpyライクに2次元データを扱う機能を提供するインターフェース
 */
interface MatrixInterface
{
    // 初期化
    public static function make(array $data): self;
    public static function init(int $size, int $dim, $fillWith = null): self;
    // 原点(行と列の番号の始点)を変更する
    public function changeOrigin(int $origin);

    // コンテナの中身の入出力
    public function setData($data, int $row, int $col): void;
    public function getData(int $row, int $col): mixed;
    public function toArray();

    public function getRow(int|array $position, bool $split=false): array;
    public function getCol(int|array $position, bool $split=false): array;
    public function getDiagUp(array $position, bool $split=false): array; // 右上がり(anti-diag)
    public function getDiagDown(array $position, bool $split=false): array; // 右下がり(diag)

    public function getLinesClockwise(array $position, bool $reverse=false): array;
    public function setLinesClockwise(array $lineDataList, array $position, bool $reverse=false): void;

    public function getSuroundings(array $position, bool $reverse=false);

    // 空の要素が設定されている部分を指定した値で埋める
    public function fill($value): self;
    // 一次元配列として取得。
    public function flatten(): array;
    // 行列の要素数を二次元配列で取得する
    public function shape(): array;
    public function size(): int;
    public function dim(): int;
}
