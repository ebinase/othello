<?php

namespace Packages\Models\Participant;

interface ParticipantInterface
{
    const PARTICIPANT_TYPE_PLAYER = 'PLAYER';
    const PARTICIPANT_TYPE_BOT   = 'BOT';

    public function getId(): string;
    public function getName(): string;
    public function getPlayerType(): string;

    public function isPlayer(): bool;
    public function isBot(): bool;

    public function equals(ParticipantInterface $participant): bool;
}
