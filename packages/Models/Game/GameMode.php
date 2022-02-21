<?php

namespace Packages\Models\Game;

/**
 * ゲームモードを表す区分オブジェクト
 */
class GameMode
{
    const GAME_MODE_VS_PLAYER = '01';
    const GAME_MODE_VS_BOT    = '02';
    const GAME_MODE_VIEWING   = '03';

    private static array $modeList = [
        self::GAME_MODE_VS_PLAYER,
        self::GAME_MODE_VS_BOT,
        self::GAME_MODE_VIEWING,
    ];

    private static array $modeNameList = [
        self::GAME_MODE_VS_PLAYER => 'プレイヤー対戦(PVP)',
        self::GAME_MODE_VS_BOT    => 'ボット対戦',
        self::GAME_MODE_VIEWING   => '観戦モード',
    ];

    public function __construct(
        private string $modeCode
    )
    {
        if (!in_array($modeCode, self::$modeList)) throw new \RuntimeException();
    }

    // ---------------------------------------
    // 初期化
    // ---------------------------------------
    public static function make(string $modeCode): GameMode
    {
        return new GameMode($modeCode);
    }

    public static function vsPlayerMode(): GameMode
    {
        return new GameMode(self::GAME_MODE_VS_PLAYER);
    }

    public static function vsBotMode(): GameMode
    {
        return new GameMode(self::GAME_MODE_VS_BOT);
    }

    public static function viewingMode(): GameMode
    {
        return new GameMode(self::GAME_MODE_VIEWING);
    }

    // ---------------------------------------
    // 判定系
    // ---------------------------------------
    public function isVsPlayerMode(): bool
    {
        return $this->modeCode === self::GAME_MODE_VS_PLAYER;
    }

    public function isVsBotMode(): bool
    {
        return $this->modeCode === self::GAME_MODE_VS_BOT;
    }

    public function isViewingMode(): bool
    {
        return $this->modeCode === self::GAME_MODE_VIEWING;
    }

    // ---------------------------------------
    // getter
    // ---------------------------------------
    public function getName(): string
    {
        return self::$modeNameList[$this->modeCode];
    }
}
