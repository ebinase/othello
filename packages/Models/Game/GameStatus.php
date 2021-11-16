<?php

namespace Packages\Models\Game;

/**
 * ゲームの状態を表す区分オブジェクト
 */
class GameStatus
{
    const GAME_STATUS_PLAYING = '01';
    const GAME_STATUS_FINISHED = '02';
//    const GAME_STATUS_SUSPENDED = '03';

    private static array $statusList = [
        self::GAME_STATUS_PLAYING,
        self::GAME_STATUS_FINISHED,
//        self::GAME_STATUS_SUSPENDED,
    ];

    private static array $statusNameList = [
        self::GAME_STATUS_PLAYING   => 'プレー中',
        self::GAME_STATUS_FINISHED  => 'ゲーム終了',
//        self::GAME_STATUS_SUSPENDED => '一時停止中',
    ];

    public function __construct(
        private string $statusCode
    )
    {
        if (!in_array($statusCode, self::$statusList)) throw new \RuntimeException();
    }

    // ---------------------------------------
    // 初期化
    // ---------------------------------------
    public static function make(string $statusCode): GameStatus
    {
        return new GameStatus($statusCode);
    }

    public static function start(): GameStatus
    {
        return new GameStatus(self::GAME_STATUS_PLAYING);
    }

    public static function finish(): GameStatus
    {
        return new GameStatus(self::GAME_STATUS_FINISHED);
    }

    // ---------------------------------------
    // 判定系
    // ---------------------------------------
    public function isPlaying(): bool
    {
        return $this->statusCode === self::GAME_STATUS_PLAYING;
    }

    public function isFinished(): bool
    {
        return $this->statusCode === self::GAME_STATUS_FINISHED;
    }

    // ---------------------------------------
    // getter
    // ---------------------------------------
    public function getName(): string
    {
        return self::$statusNameList[$this->statusCode];
    }
}
