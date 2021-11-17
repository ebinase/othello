<?php

namespace Tests\Feature\Game;

use Packages\Models\Game\Game;
use Packages\Models\Game\GameMode;
use Packages\Models\Game\GameStatus;
use Packages\Models\Game\Participants;
use Packages\Models\Player\Bot;
use Packages\Models\Player\Player;
use Packages\Models\Turn\Turn;
use Tests\TestCase;

class GameInitializingTest extends TestCase
{
    /** @test */
    public function プレイヤー対戦モードでの初期化()
    {
        // given:
        $gameId = 'test_id';

        // when:
        $mode = GameMode::vsPlayerMode();
        $whitePlayer = new Player('01', 'player_white');
        $blackPlayer = new Player('02', 'player_black');
        $participants = Participants::make($whitePlayer, $blackPlayer);

        $game = Game::init($gameId, $mode, $participants);

        // then:
        self::assertSame($gameId, $game->getId());
        // HACK: equals()を生やして比較
        self::assertSame(true, $mode == $game->getMode());
        self::assertSame(true, $participants == $game->getParticipants());
        self::assertSame(true, GameStatus::GAME_STATUS_PLAYING == $game->getStatus()->toCode());
        self::assertSame(true, Turn::init() == $game->getTurn());
    }

    /** @test */
    public function プレイヤー対戦モードでの初期化でBotが呼ばれた場合はエラー()
    {
        // given:
        $gameId = 'test_id';
        // when:
        $mode = GameMode::vsPlayerMode();

        $player1 = new Player('01', 'player_1');
        $bot1 = new Bot('03', 'bot_1');
        $bot2 = new Bot('04', 'bot_2');

        $playerAndBot = Participants::make($player1, $bot1);
        $bots = Participants::make($bot1, $bot2);
        // then:
        $this->expectException(\RuntimeException::class);
        Game::init($gameId, $mode, $playerAndBot);
        $this->expectException(\RuntimeException::class);
        Game::init($gameId, $mode, $bots);
    }

    /** @test */
    public function Bot対戦モードでの初期化()
    {
        // given:
        $gameId = 'test_id';
        // when:
        $mode = GameMode::vsBotMode();
        $whitePlayer = new Player('01', 'player_white');
        $blackPlayer = new Bot('02', 'player_black');
        $participants = Participants::make($whitePlayer, $blackPlayer);

        $game = Game::init($gameId, $mode, $participants);

        // then:
        self::assertSame($gameId, $game->getId());
        // HACK: equals()を生やして比較
        self::assertSame(true, $mode == $game->getMode());
        self::assertSame(true, $participants == $game->getParticipants());
        self::assertSame(true, GameStatus::GAME_STATUS_PLAYING == $game->getStatus()->toCode());
        self::assertSame(true, Turn::init() == $game->getTurn());
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
        $bot1 = new Bot('03', 'bot_1');
        $bot2 = new Bot('04', 'bot_2');
        $players = Participants::make($player1, $player2);
        $bots = Participants::make($bot1, $bot2);
        // then:
        $this->expectException(\RuntimeException::class);
        Game::init($gameId, $mode, $players);
        $this->expectException(\RuntimeException::class);
        Game::init($gameId, $mode, $bots);
    }

    /** @test */
    public function Bot観戦モードでの初期化()
    {
        // given:
        $gameId = 'test_id';

        // when:
        $mode = GameMode::viewingMode();
        $bot1 = new Bot('03', 'bot_1');
        $bot2 = new Bot('04', 'bot_2');
        $bots = Participants::make($bot1, $bot2);

        $game = Game::init($gameId, $mode, $bots);

        // then: 例外が出ずに生成されることを確認
        self::assertSame($gameId, $game->getId());
        // HACK: equals()を生やして比較
        self::assertSame(true, $mode == $game->getMode());
        self::assertSame(true, $bots == $game->getParticipants());
        self::assertSame(true, GameStatus::GAME_STATUS_PLAYING == $game->getStatus()->toCode());
        self::assertSame(true, Turn::init() == $game->getTurn());
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
        $bot1 = new Bot('03', 'bot_1');

        $players = Participants::make($player1, $player2);
        $botAndPlayer = Participants::make($bot1, $player1);
        // then:
        $this->expectException(\RuntimeException::class);
        Game::init($gameId, $mode, $players);
        $this->expectException(\RuntimeException::class);
        Game::init($gameId, $mode, $botAndPlayer);
    }
}
