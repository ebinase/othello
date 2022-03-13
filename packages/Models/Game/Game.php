<?php

namespace Packages\Models\Game;

use Packages\Models\Board\Color\Color;
use Packages\Models\Board\Position\Position;
use Packages\Models\Bot\BotFactory;
use Packages\Models\Participant\ParticipantInterface;
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

    public function process(?Position $playerMove = null): Game
    {
        if (!$this->gameStatus->isPlaying()) throw new \RuntimeException();

        if ($this->isBotTurn() && !$this->turn->mustSkip()) {
            // TODO: ターンとプレイヤーの行動制限についてもう少し検討する(更新と制限処理の分離など)
            if (isset($playerMove)) throw new \RuntimeException('ボットのターンにプレイヤーが行動することはできません。');

            // ボットを起動して置く場所を算出する
            $bot = BotFactory::make($this->getCurrentPlayer()->getId());
            $playerMove = $bot->run($this->turn);
        }

        $nextTurn = $this->turn->next($playerMove);

        if (!$nextTurn->isContinuable() || $nextTurn->finishedLastTurn()) {
            $nextGameStatus = GameStatus::finish();
        }
        return new Game(
            $this->id,
            $this->gameMode,
            $this->participants,
            $nextGameStatus ?? $this->gameStatus,
            $nextTurn
        );
    }

    public function isGameOver(): bool
    {
        return $this->gameStatus->isFinished();
    }

    public function determinResult()
    {
        if (!$this->isGameOver()) throw new \RuntimeException();
    }

    // TODO: あとでリファクタリング
    public function getWinner(): ?ParticipantInterface
    {
        if (!$this->isGameOver()) throw new \RuntimeException();

        $whiteScore = $this->turn->getBoard()->getPoint(Color::white());
        $blackScore = $this->turn->getBoard()->getPoint(Color::black());

        // 勝敗判定
        if ($whiteScore > $blackScore) {
            return $this->participants->whitePlayer();
        } elseif ($whiteScore < $blackScore) {
            return $this->participants->blackPlayer();
        }
        // 勝者がいない場合はnull
        return null;
    }

    public function isBotTurn(): bool
    {
        // プレイヤー同士の対戦にはボットが存在しない
        if ($this->gameMode->isVsPlayerMode()) return false;
        // 観戦モードではボットのターンしか存在しない
        if ($this->gameMode->isViewingMode()) return true;

        // ボット対戦モードの場合
        return $this->getCurrentPlayer()->isBot();
    }

    public function getCurrentPlayer(): ParticipantInterface
    {
        return $this->participants->findByColor($this->turn->getPlayableColor());
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
