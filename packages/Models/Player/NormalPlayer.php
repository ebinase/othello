<?php

namespace Packages\Models\Player;

use http\Exception\InvalidArgumentException;

/**
 * プレイヤーを表すクラス
 */
final class NormalPlayer extends BasePlayer
{
    public function __construct($id, $name = 'プレイヤー', $type = self::PLAYER_TYPE_PREFIX_PLAYER . '01')
    {
        parent::__construct($id, $name, $type);

        if (!$this->isPlayer()) throw new InvalidArgumentException();

    }
}
