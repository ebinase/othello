<?php
namespace Packages\Models\Bot;

enum BotType: string
{
    case RANDOM = '01';
    case SINGLE_OPENNESS = '02';

    /**
     * @return string
     */
    public function getBotName(): string
    {
        return match ($this) {
            BotType::RANDOM => 'ランダムボット',
            BotType::SINGLE_OPENNESS => '単一開放度ボット',
        };
    }
}
