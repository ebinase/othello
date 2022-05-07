<?php

namespace Tests\Feature\Models\GameOrganizer;

use Packages\Models\GameOrganizer\Game;
use Packages\Models\GameOrganizer\GameMode;
use Packages\Models\GameOrganizer\Participant\BotParticipant;
use Packages\Models\GameOrganizer\Participant\Player;
use Packages\Models\GameOrganizer\Participants;
use Tests\TestCase;

/**
 * 不正なパラメータでの初期化が弾かれることを確認する
 *
 * 正常系での初期化のテストはGameFactoryで行う
*/
class GameInvalidInitializingTest extends TestCase
{
    /** @test */
    public function プレイヤー対戦モードでの初期化でBotが呼ばれた場合はエラー()
    {
        // given:
        $gameId = 'test_id';
        // when:
        $mode = GameMode::vsPlayerMode();

        $player1 = new Player('01', 'player_1');
        $bot1 = new BotParticipant('03', 'bot_1');
        $bot2 = new BotParticipant('04', 'bot_2');

        $playerAndBot = Participants::make($player1, $bot1);
        $bots = Participants::make($bot1, $bot2);
        // then:
        $this->expectException(\RuntimeException::class);
        Game::init($gameId, $mode, $playerAndBot);
        $this->expectException(\RuntimeException::class);
        Game::init($gameId, $mode, $bots);
    }

    /** @test */
    public function Bot対戦モードでの初期化で参加者の種類が偏った場合はエラー()
    {
        // given:
        $gameId = 'test_id';
        // when:
        $mode = GameMode::vsBotMode();
        $player1 = new Player('01', 'player_1');
        $player2 = new Player('02', 'player_2');
        $bot1 = new BotParticipant('03', 'bot_1');
        $bot2 = new BotParticipant('04', 'bot_2');
        $players = Participants::make($player1, $player2);
        $bots = Participants::make($bot1, $bot2);
        // then:
        $this->expectException(\RuntimeException::class);
        Game::init($gameId, $mode, $players);
        $this->expectException(\RuntimeException::class);
        Game::init($gameId, $mode, $bots);
    }

    /** @test */
    public function Bot観戦モードでの初期化でプレイヤーが呼び出された場合はエラー()
    {
        // given:
        $gameId = 'test_id';
        // when:
        $mode = GameMode::vsBotMode();

        $player1 = new Player('01', 'player_1');
        $player2 = new Player('02', 'player_2');
        $bot1 = new BotParticipant('03', 'bot_1');

        $players = Participants::make($player1, $player2);
        $botAndPlayer = Participants::make($bot1, $player1);
        // then:
        $this->expectException(\RuntimeException::class);
        Game::init($gameId, $mode, $players);
        $this->expectException(\RuntimeException::class);
        Game::init($gameId, $mode, $botAndPlayer);
    }
}
