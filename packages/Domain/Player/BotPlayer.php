<?php

namespace Packages\Domain\Player;

use Packages\Domain\Bot\BotStrategyInterface;

/**
 * プレイヤーとしてのBotを表すクラス
 */
final class BotPlayer extends BasePlayer
{
    private BotStrategyInterface $bot;

    public function __construct($id, $name)
    {
        parent::__construct($id, $name, self::PLAYER_TYPE_BOT);
    }

    function getMove(): int
    {
        return $this->bot->culculate();
    }
}
