<?php

namespace Packages\Models\Bot\Bots;

use Packages\Models\Board\Position\Position;
use Packages\Models\Bot\BotInterface;
use Packages\Models\Bot\Calculators\Openness\SelfOpennessCalculator;
use Packages\Models\Bot\Calculators\Random\RandomCalculator;
use Packages\Models\Turn\Turn;

class SelfOpennessBot implements BotInterface
{
    public function run(Turn $turn): Position
    {
        // 周囲の空きマスの数 => 座標、の形式で結果を取得
        $result = SelfOpennessCalculator::calculate($turn);
        // 最小の周辺開放度を取得
        $minOpenness = min(array_keys($result));
        // 開放度が最小な座標の中からランダムに返す
        return RandomCalculator::calculate($result[$minOpenness]);
    }
}
