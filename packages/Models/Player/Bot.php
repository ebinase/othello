<?php

namespace Packages\Models\Player;

use http\Exception\InvalidArgumentException;
use Packages\Models\Bot\BotFactory;

/**
 * プレイヤーとしてのBotを表すクラス
 */
final class Bot extends BasePlayer
{
    public function __construct($id, $name = 'ボット', $type = BotFactory::BOT_ID_RANDOM)
    {
        $type = self::PLAYER_TYPE_PREFIX_BOT . $type;

        parent::__construct($id, $name, $type);

        if (!$this->isBot()) throw new InvalidArgumentException();
    }
}
