<?php

namespace Packages\Models\Game;

use Packages\Models\Board\Position\Position;
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
        // プレイヤー対戦時に参加者がプレイヤーのみであること
        if ($this->gameMode->isVsPlayerMode() && !$this->participants->hasOnlyPlayers()) {
            throw new \RuntimeException('ゲームモードと参加者の種類の組み合わせが正しくありません');
        }
        // ボット対戦時に参加者にプレイヤーとボットが両方いること(偏りがないこと)
        if ($this->gameMode->isVsBotMode() && ($this->participants->hasOnlyPlayers() || $this->participants->hasOnlyBots())) {
            throw new \RuntimeException('ゲームモードと参加者の種類の組み合わせが正しくありません');
        }
        // 観戦時に参加者がボットのみであること
        if ($this->gameMode->isViewingMode() && !$this->participants->hasOnlyBots()) {
            throw new \RuntimeException('ゲームモードと参加者の種類の組み合わせが正しくありません');
        }

        // ゲームステータスとターンの状態チェック
        if ($this->gameStatus->isPlaying() && $this->isGameOver()) {
            throw new \RuntimeException('ゲームステータスとターンの状態が一致しません');
        }
        if ($this->gameStatus->isFinished() && !$this->isGameOver()) {
            throw new \RuntimeException('ゲームステータスとターンの状態が一致しません');
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

    public static function make(string $id, GameMode $gameMode, Participants $participants, GameStatus $status, Turn $turn)
    {
        return new Game(
            id:           $id,
            gameMode:     $gameMode,
            participants: $participants,
            gameStatus:   $status,
            turn:         $turn
        );
    }

    public function process(?Position $playerMove = null)
    {
        if (!$this->gameStatus->isPlaying()) throw new \RuntimeException();

        $this->turn = $this->turn->next($playerMove);

        if (!$this->turn->isContinuable() || $this->turn->finishedLastTurn()) {
            $this->gameStatus = GameStatus::finish();
        }
    }

    public function isGameOver(): bool
    {
        return $this->gameStatus->isFinished();
    }

    public function determinResult()
    {
        if (!$this->isGameOver()) throw new \RuntimeException();
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
