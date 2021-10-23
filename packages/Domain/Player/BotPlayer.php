<?php

namespace Packages\Domain\Player;

use Packages\Domain\Bot\BotStrategyInterface;

/**
 * プレイヤーとしてのBotを表すクラス
 */
final class BotPlayer implements PlayerInterface
{
    private BotStrategyInterface $bot;

    public function __construct($bot)
    {
        if ($bot instanceof BotStrategyInterface) {
            $this->bot = $bot;
        }


    }

    function getMove(): int
    {
        return $this->bot->culculate();
    }
}
