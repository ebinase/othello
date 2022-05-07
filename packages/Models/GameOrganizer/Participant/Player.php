<?php

namespace Packages\Models\GameOrganizer\Participant;

use http\Exception\InvalidArgumentException;

/**
 * プレイヤーを表すクラス
 */
final class Player extends BaseParticipant
{
    public function __construct($id, $name = 'プレイヤー', $type = self::PARTICIPANT_TYPE_PLAYER)
    {
        parent::__construct($id, $name, $type);

        if (!$this->isPlayer()) throw new InvalidArgumentException();
    }
}
