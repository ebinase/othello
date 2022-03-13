<?php

namespace Packages\Models\Player;

use http\Exception\InvalidArgumentException;

/**
 * プレイヤーを表すクラス
 */
final class Player extends BasePlayer
{
    public function __construct($id, $name = 'プレイヤー', $type = self::PLAYER_TYPE_HUMAN . '01')
    {
        parent::__construct($id, $name, $type);

        if (!$this->isPlayer()) throw new InvalidArgumentException();

    }
}
