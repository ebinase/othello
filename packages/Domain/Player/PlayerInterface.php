<?php

namespace Packages\Domain\Player;

interface PlayerInterface
{
    const PLAYER_TYPE_PREFIX_PERSON = 'P';
    const PLAYER_TYPE_PREFIX_BOT    = 'B';

    public function getid(): string;
    public function getName(): string;
    public function getPlayerType(): string;

    public function isPerson(): bool;
    public function isBot(): bool;
}
