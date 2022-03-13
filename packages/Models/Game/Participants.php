<?php

namespace Packages\Models\Game;

use Packages\Models\Board\Color\Color;
use Packages\Models\Participant\ParticipantInterface;

class Participants
{
    const MAX_PARTICIPANTS = 2;

    /**
     * ゲームへの参加者のリスト
     * 人間は"Player", ボットは"BotParticipant"
     * @var array<string, ParticipantInterface>
     */
    private array $participants;

    private function __construct(ParticipantInterface $whiteParticipant, ParticipantInterface $blackParticipant,)
    {
        $this->participants[Color::white()->toCode()] = $whiteParticipant;
        $this->participants[Color::black()->toCode()] = $blackParticipant;
    }

    // ---------------------------------------
    // 生成系
    // ---------------------------------------
    /**
     * @param ParticipantInterface $whiteParticipant
     * @param ParticipantInterface $blackParticipant
     * @return Participants
     */
    public static function make(ParticipantInterface $whiteParticipant, ParticipantInterface $blackParticipant): Participants
    {
        return new Participants($whiteParticipant, $blackParticipant);
    }

    // ---------------------------------------
    // 判定系
    // ---------------------------------------
    public function hasOnlyPlayers(): bool
    {
        return $this->countPlayers() === self::MAX_PARTICIPANTS;
    }

    public function hasOnlyBots(): bool
    {
        return $this->countBots() === self::MAX_PARTICIPANTS;
    }

    public function countPlayers(): int
    {
        return count($this->players());
    }

    public function countBots(): int
    {
        return count($this->bots());
    }

    // ---------------------------------------
    // getter
    // ---------------------------------------
    public function whitePlayer(): ParticipantInterface
    {
        return $this->participants[Color::white()->toCode()];
    }

    public function blackPlayer(): ParticipantInterface
    {
        return $this->participants[Color::black()->toCode()];
    }

    public function players(): array
    {
        return array_filter($this->participants, function ($participant) {
            return $participant->isPlayer();
        });
    }

    public function bots(): array
    {
        return array_filter($this->participants, function ($participant) {
            return $participant->isBot();
        });
    }

    public function findByColor(Color $color): ?ParticipantInterface
    {
        return $this->participants[$color->toCode()] ?? null;
    }
}
