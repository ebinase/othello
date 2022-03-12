<?php

namespace Tests\Feature\Bot;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Packages\Models\Board\Board;
use Packages\Models\Board\Position\Position;
use Packages\Models\Bot\BotFactory;
use Packages\Models\Bot\BotInterface;
use Packages\Models\Bot\Calculators\Random\RandomCalculator;
use Packages\Models\Bot\Levels\LevelFactory;
use Packages\Models\Board\Color\Color;
use Packages\Models\Player\Bot;
use Packages\Models\Turn\Turn;
use Tests\TestCase;
use function PHPUnit\Framework\assertSame;

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
