<?php

namespace Packages\Domain\Player;

interface PlayerInterface
{
    const PLAYER_TYPE_HUMAN = '01';
    const PLAYER_TYPE_BOT   = '02';

    public function getid(): string;
    public function getName(): string;
    public function getPlayerType(): string;

    public function isHuman(): bool;
    public function isBot(): bool;
}
