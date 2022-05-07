<?php

namespace Tests\Feature\Models\Bot;

use Packages\Models\Bot\BotFactory;
use Packages\Models\Bot\BotType;
use Packages\Models\Bot\Levels\LevelFactory;
use Packages\Models\Othello\Board\Position\Position;
use Packages\Models\Othello\Turn\Turn;
use Tests\TestCase;

class BotTest extends TestCase
{
    /** @test */
    public function 全てのボットが期待した通りの動作をする()
    {
        // given:
        $turn = Turn::init();
        foreach (BotType::cases() as $type) {
            $bots[] = BotFactory::make($type);
        }
        // when:
        foreach ($bots as $bot) {
            $results[] = $bot->run($turn);
        }

        // then:
        foreach ($results as $result) {
            self::assertTrue($result instanceof Position);
        }
    }
}
