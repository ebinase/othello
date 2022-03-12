<?php

namespace Tests\Feature\Bot;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Packages\Models\Board\Board;
use Packages\Models\Bot\BotFactory;
use Packages\Models\Bot\BotInterface;
use Packages\Models\Bot\Bots\RandomBot;
use Packages\Models\Bot\Calculators\Random\RandomCalculator;
use Packages\Models\Bot\Levels\LevelFactory;
use Packages\Models\Board\Color\Color;
use Packages\Models\Player\Bot;
use Packages\Models\Turn\Turn;
use Tests\TestCase;
use function PHPUnit\Framework\assertSame;

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
