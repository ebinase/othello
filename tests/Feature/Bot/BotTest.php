<?php

namespace Tests\Feature\Bot;

use Packages\Models\Board\Position\Position;
use Packages\Models\Bot\BotFactory;
use Packages\Models\Bot\Levels\LevelFactory;
use Packages\Models\Turn\Turn;
use Tests\TestCase;

class BotTest extends TestCase
{
    /** @test */
    public function ボット実行()
    {
        // given:
        $bot = BotFactory::make(BotFactory::BOT_ID_RANDOM);
        $turn = Turn::init();
        // when:
        $result = $bot->run($turn);
        // then:
        self::assertTrue($result instanceof Position);
    }
}
