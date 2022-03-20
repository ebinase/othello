<?php

namespace Tests\Feature\Bot;

use Packages\Models\Bot\BotFactory;
use Packages\Models\Bot\BotInterface;
use Packages\Models\Bot\Bots\RandomBot;
use Packages\Models\Bot\BotType;
use Packages\Models\Bot\Levels\LevelFactory;
use Tests\TestCase;

class BotFactoryTest extends TestCase
{
    /** @test */
    public function 意図した通りのボットが生成される()
    {
        // given:
        // when:
        $bot = BotFactory::make(BotType::RANDOM);
        // then:
        self::assertTrue($bot instanceof RandomBot);
    }
}
