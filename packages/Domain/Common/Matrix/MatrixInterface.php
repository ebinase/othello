<?php

namespace Packages\Domain\Common\Matrix;

/**
 * numpyライクに2次元データを扱う機能を提供するインターフェース
 */
interface MatrixInterface
{
    // 初期化
    public static function make(array ...$arrayList): self;
    public static function init(int $size, int $dim, $fillWith = null): self;
    // 原点(行と列の番号の始点)を変更する
    public function changeOrigin(int $origin);

    // コンテナの中身の入出力
    public function setData($data, int $row, int $col);
    public function getData(int $row, int $col);
    public function toArray();

    public function getRow($rowNum);
    public function getCol($colNum);
    public function getDiag($rowNum, $colNum);
    public function getLine($direction, $oneWay);

    // 空の要素が設定されている部分を指定した値で埋める
    public function fill($value): self;
    // 一次元配列に変形。
    public function flat($offset): self;
    // 行列の要素数を二次元配列で取得する
    public function shape(): array;
}
