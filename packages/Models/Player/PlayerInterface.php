<?php

namespace Packages\Models\Player;

interface PlayerInterface
{
    const PLAYER_TYPE_PREFIX_PLAYER = 'P';
    const PLAYER_TYPE_PREFIX_BOT    = 'B';

    public function getid(): string;
    public function getName(): string;
    public function getPlayerType(): string;

    public function isPlayer(): bool;
    public function isBot(): bool;

    public function equals(PlayerInterface $player): bool;
}
