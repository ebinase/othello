<?php

namespace Packages\Domain\Player;

use Packages\Domain\Bot\BotStrategyInterface;

/**
 * プレイヤーを表すクラス
 */
final class Player extends BasePlayer
{
    public function __construct($id, $name)
    {
        parent::__construct($id, $name, self::PLAYER_TYPE_HUMAN);
    }
}
