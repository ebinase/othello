<?php

namespace Tests\Feature\Bot;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Packages\Models\Board\Board;
use Packages\Models\Bot\BotFactory;
use Packages\Models\Bot\Calculators\Random\RandomCalculator;
use Packages\Models\Bot\Levels\LevelFactory;
use Packages\Models\Board\Color\Color;
use Packages\Models\Turn\Turn;
use Tests\TestCase;
use function PHPUnit\Framework\assertSame;

class BotFactoryTest extends TestCase
{
    const COLOR_WHITE = 1;
    const COLOR_BLACK = 2;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRandomBotが生成される()
    {
        // given:
        // 初期盤面
        $turn = Turn::init();
        // when:
        $bot = BotFactory::make(BotFactory::BOT_ID_RANDOM, $turn);
        // then:
        self::assertEquals($bot->getLevel()->getLevelCode(),  LevelFactory::make(LevelFactory::BOT_LEVEL_01)->getLevelCode());
//        assertSame($bot->getCalculator(),  (new RandomCalculator($turn)));
    }
}
