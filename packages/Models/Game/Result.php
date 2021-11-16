<?php

namespace Packages\Models\Game;

use Packages\Models\Board\Color\Color;

/**
 * ゲームの結果を表す区分オブジェクト
 */
class Result
{
    // 正常決着
    const GAME_RESULT_WHITE_WINS      = '01';
    const GAME_RESULT_BLACK_WINS      = '02';
    const GAME_RESULT_DRAW_GAME       = '03';
    // 途中終了
    const GAME_RESULT_DOUBLE_SKIP     = '04';
//    const GAME_RESULT_QUIT            = '05';
//    const GAME_RESULT_WHITE_SURRENDER = '06';
//    const GAME_RESULT_BLACK_SURRENDER = '07';

    private static array $resultList = [
        self::GAME_RESULT_WHITE_WINS,
        self::GAME_RESULT_BLACK_WINS,
        self::GAME_RESULT_DRAW_GAME,
        self::GAME_RESULT_DOUBLE_SKIP,
    ];

    private static array $resultNameList = [
        self::GAME_RESULT_WHITE_WINS      => '白勝利',
        self::GAME_RESULT_BLACK_WINS      => '黒勝利',
        self::GAME_RESULT_DRAW_GAME       => '引き分け',
        self::GAME_RESULT_DOUBLE_SKIP     => '途中終了(スキップ連続)',
    ];

    private static array $resultColorList = [
        self::GAME_RESULT_WHITE_WINS      => Color::COLOR_CODE_WHITE,
        self::GAME_RESULT_BLACK_WINS      => Color::COLOR_CODE_BLACK,
        self::GAME_RESULT_DRAW_GAME       => null, // HACK: ステータスを作るべきかも
        self::GAME_RESULT_DOUBLE_SKIP     => null, // HACK: ステータスを作るべきかも
    ];

    /**
     * 途中終了せず最後のターンまで到達したゲームのステータス
     * @var string[]
     */
    private static array $resultsForCompleted = [
        self::GAME_RESULT_WHITE_WINS,
        self::GAME_RESULT_BLACK_WINS,
        self::GAME_RESULT_DRAW_GAME,
    ];

    /**
     * ルールによって途中終了したゲームのステータス
     * @var string[]
     */
    private static array $resultsForNotCompleted = [
        self::GAME_RESULT_DOUBLE_SKIP,
    ];

    public function __construct(
        private string $resultCode
    )
    {
        if (!in_array($resultCode, self::$resultList)) throw new \RuntimeException();
    }

    // ---------------------------------------
    // 初期化
    // ---------------------------------------
    public static function make(string $resultCode): Result
    {
        return new Result($resultCode);
    }

    // ---------------------------------------
    // 判定系
    // ---------------------------------------
    public function isCompleted(): bool
    {
        return in_array($this->resultCode, self::$resultsForCompleted);
    }

    // ---------------------------------------
    // getter
    // ---------------------------------------
    public function getName(): string
    {
        return self::$resultNameList[$this->resultCode];
    }
}
