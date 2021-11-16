<?php

namespace Packages\Models\Game;

use Packages\Models\Board\Color\Color;
use Packages\Models\Player\PlayerInterface;

class Participants
{
    /**
     * ゲームへの参加者のリスト
     * 人間は"Player", ボットは"Bot"
     * @var array<string, PlayerInterface>
     */
    private array $participants;

    private function __construct(PlayerInterface $whitePlayer, PlayerInterface $blackPlayer,)
    {
        $this->participants[Color::white()->toCode()] = $whitePlayer;
        $this->participants[Color::black()->toCode()] = $blackPlayer;
    }

    /**
     * @param PlayerInterface $whitePlayer
     * @param PlayerInterface $blackPlayer
     * @return Participants
     */
    public static function make(PlayerInterface $whitePlayer, PlayerInterface $blackPlayer): Participants
    {
        return new Participants($whitePlayer, $blackPlayer);
    }

    public function whitePlayer(): PlayerInterface
    {
        return $this->participants[Color::white()->toCode()];
    }

    public function blackPlayer(): PlayerInterface
    {
        return $this->participants[Color::black()->toCode()];
    }

    public function players(): array
    {
        return array_filter($this->participants, function ($player) {
            $player->isPlayer();
        });
    }

    public function bots(): array
    {
        return array_filter($this->participants, function ($player) {
            $player->isBot();
        });
    }


    public function countPlayers(): int
    {
        return count($this->players());
    }

    public function countBots(): int
    {
        return count($this->bots());
    }
}
