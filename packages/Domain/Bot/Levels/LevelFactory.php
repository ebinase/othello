<?php

namespace Packages\Domain\Bot\Levels;

class LevelFactory
{
    // TODO: enum
    const BOT_LEVEL_01 = '01';
    const BOT_LEVEL_02 = '02';
    const BOT_LEVEL_03 = '03';
    const BOT_LEVEL_04 = '04';
    const BOT_LEVEL_05 = '05';

    const BOT_LEVEL_NAME_01 = 'レベル1';
    const BOT_LEVEL_NAME_02 = 'レベル2';
    const BOT_LEVEL_NAME_03 = 'レベル3';
    const BOT_LEVEL_NAME_04 = 'レベル4';
    const BOT_LEVEL_NAME_05 = 'レベル5';

    const BOT_LEVEL_DESCRIPTION_01 = 'さいじゃく';
    const BOT_LEVEL_DESCRIPTION_02 = 'よわい';
    const BOT_LEVEL_DESCRIPTION_03 = 'そこそこ';
    const BOT_LEVEL_DESCRIPTION_04 = 'つよめ';
    const BOT_LEVEL_DESCRIPTION_05 = 'つよい';

    private static array $levelList = [
        self::BOT_LEVEL_01 => self::BOT_LEVEL_NAME_01,
        self::BOT_LEVEL_02 => self::BOT_LEVEL_NAME_02,
        self::BOT_LEVEL_03 => self::BOT_LEVEL_NAME_03,
        self::BOT_LEVEL_04 => self::BOT_LEVEL_NAME_04,
        self::BOT_LEVEL_05 => self::BOT_LEVEL_NAME_05,
    ];

    private static array $levelDescriptionList = [
        self::BOT_LEVEL_01 => self::BOT_LEVEL_DESCRIPTION_01,
        self::BOT_LEVEL_02 => self::BOT_LEVEL_DESCRIPTION_02,
        self::BOT_LEVEL_03 => self::BOT_LEVEL_DESCRIPTION_03,
        self::BOT_LEVEL_04 => self::BOT_LEVEL_DESCRIPTION_04,
        self::BOT_LEVEL_05 => self::BOT_LEVEL_DESCRIPTION_05,
    ];

    public static function make(string $levelCode): BotLevel
    {
        return new BotLevel(
            $levelCode,
            self::$levelList[$levelCode],
            self::$levelDescriptionList[$levelCode],
        );
    }
}
