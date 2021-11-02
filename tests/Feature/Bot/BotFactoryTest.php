<?php

namespace Tests\Feature\Bot;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Packages\Domain\Board\Board;
use Packages\Domain\Bot\BotFactory;
use Packages\Domain\Bot\Calculators\Random\RandomCalculator;
use Packages\Domain\Bot\Levels\LevelFactory;
use Packages\Domain\Color\Color;
use Packages\Domain\Turn\Turn;
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
        $emptyRow = collect()->pad(8, 0)->toArray();
        $initBoard = [
            $emptyRow,
            $emptyRow,
            $emptyRow,
            collect($emptyRow)->put(3, self::COLOR_WHITE)->put(4, self::COLOR_BLACK)->toArray(),
            collect($emptyRow)->put(3, self::COLOR_BLACK)->put(4, self::COLOR_WHITE)->toArray(),
            $emptyRow,
            $emptyRow,
            $emptyRow,
        ];
        $board = new Board($initBoard);
        $turn = new Turn(1, Color::white(), $board, 0);
        // when:
        $bot = BotFactory::make(BotFactory::BOT_ID_RANDOM, $turn);
        // then:
        self::assertEquals($bot->getLevel()->getLevelCode(),  LevelFactory::make(LevelFactory::BOT_LEVEL_01)->getLevelCode());
//        assertSame($bot->getCalculator(),  (new RandomCalculator($turn)));
    }
}
