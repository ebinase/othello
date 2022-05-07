<?php

namespace Packages\Models\GameOrganizer\Participant;

use http\Exception\InvalidArgumentException;

/**
 * 参加者としてのBotを表すクラス
 */
final class BotParticipant extends BaseParticipant
{
    public function __construct($id, $name = 'ボット', $type = self::PARTICIPANT_TYPE_BOT)
    {
        parent::__construct($id, $name, $type);

        if (!$this->isBot()) throw new InvalidArgumentException();
    }
}
