<?php

namespace Packages\Models\Game;

use Packages\Models\Turn\Turn;

class Game
{
    private function __construct(
        private string       $id,
        private GameMode     $gameMode,
        private Participants $participants,
        private GameStatus   $gameStatus,
        private Turn         $turn,
    )
    {
        // ゲームモードと実際の参加者の組み合わせをチェック
        switch (true) {
            // プレイヤー対戦時に参加者がプレイヤーのみであること
            case $this->gameMode->isVsPlayerMode() && !$this->participants->hasOnlyPlayers():
            // ボット対戦時に参加者にプレイヤーとボットが両方いること(偏りがないこと)
            case $this->gameMode->isVsBotMode() && ($this->participants->hasOnlyPlayers() || $this->participants->hasOnlyBots()):
            // 観戦時に参加者がボットのみであること
            case $this->gameMode->isViewingMode() && !$this->participants->hasOnlyBots():
                throw new \RuntimeException('ゲームモードと参加者の種類の組み合わせが正しくありません');
            default:
                break;
        }

    }

    public static function init(string $id, GameMode $gameMode, Participants $participants)
    {
        return new Game(
            id:           $id,
            gameMode:     $gameMode,
            participants: $participants,
            gameStatus:   GameStatus::playing(),
            turn:         Turn::init()
        );
    }

    public function process(?Position $playerMove = null)
    {


        $this->turn = $this->turn->next($playerMove);
    }

    public function isGameOver(): bool
    {

    }

    public function determinResult()
    {

    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return GameMode
     */
    public function getMode(): GameMode
    {
        return $this->gameMode;
    }

    /**
     * @return Participants
     */
    public function getParticipants(): Participants
    {
        return $this->participants;
    }

    /**
     * @return GameStatus
     */
    public function getStatus(): GameStatus
    {
        return $this->gameStatus;
    }

    /**
     * @return Turn
     */
    public function getTurn(): Turn
    {
        return $this->turn;
    }
}
