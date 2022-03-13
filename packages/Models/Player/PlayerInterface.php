<?php

namespace Packages\Models\Player;

interface PlayerInterface
{
    const PLAYER_TYPE_HUMAN = 'HUMAN';
    const PLAYER_TYPE_BOT   = 'BOT';

    public function getid(): string;
    public function getName(): string;
    public function getPlayerType(): string;

    public function isPlayer(): bool;
    public function isBot(): bool;

    public function equals(PlayerInterface $player): bool;
}
