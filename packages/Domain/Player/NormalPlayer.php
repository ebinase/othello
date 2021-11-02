<?php

namespace Packages\Domain\Player;

use http\Exception\InvalidArgumentException;

/**
 * プレイヤーを表すクラス
 */
final class NormalPlayer extends BasePlayer
{
    public function __construct($id, $name = 'プレイヤー', $type = self::PLAYER_TYPE_PREFIX_PERSON . '01')
    {
        parent::__construct($id, $name, $type);

        if (!$this->isPerson()) throw new InvalidArgumentException();

    }
}
