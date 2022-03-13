<?php

namespace Packages\Models\Player;

use http\Exception\InvalidArgumentException;
use Packages\Models\Bot\BotFactory;

/**
 * プレイヤーとしてのBotを表すクラス
 */
final class BotPlayer extends BasePlayer
{
    public function __construct($id, $name = 'ボット', $type = self::PLAYER_TYPE_BOT)
    {
        parent::__construct($id, $name, $type);

        if (!$this->isBot()) throw new InvalidArgumentException();
    }
}
