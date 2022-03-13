<?php

namespace Tests\Feature\Bot;

use Packages\Models\Bot\BotFactory;
use Packages\Models\Bot\Bots\RandomBot;
use Packages\Models\Bot\Levels\LevelFactory;
use Tests\TestCase;

class BotFactoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRandomBotが生成される()
    {
        // given:
        $botID = BotFactory::BOT_ID_RANDOM;
        // when:
        $bot = BotFactory::make($botID);
        // then:
        self::assertTrue($bot instanceof RandomBot);
    }
}
