<?php

namespace Packages\Domain\Player;

use http\Exception\InvalidArgumentException;
use Packages\Domain\Bot\BotFactory;

/**
 * プレイヤーとしてのBotを表すクラス
 */
final class BotPlayer extends BasePlayer
{
    public function __construct($id, $name = 'ボット', $type = BotFactory::BOT_ID_RANDOM)
    {
        $type = self::PLAYER_TYPE_PREFIX_BOT . $type;

        parent::__construct($id, $name, $type);

        if (!$this->isBot()) throw new InvalidArgumentException();
    }
}
