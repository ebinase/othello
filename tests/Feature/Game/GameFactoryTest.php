<?php

namespace Tests\Feature\Game;

use Packages\Factories\Game\GameFactory;
use Packages\Models\Game\GameMode;
use Packages\Models\Game\GameStatus;
use Packages\Models\Game\Participants;
use Packages\Models\Participant\BotParticipant;
use Packages\Models\Participant\Player;
use Packages\Models\Turn\Turn;
use Tests\TestCase;

class GameFactoryTest extends TestCase
{
    /** @test */
    public function 共通項目()
    {
        // given
        $whitePlayer = new Player('01', '白プレイヤー');
        $blackPlayer = new Player('02', '黒プレイヤー');
        // when:
        $game = GameFactory::makeVsPlayerGame($whitePlayer, $blackPlayer);

        // then:
        self::assertTrue(\Str::isUuid($game->getId()));
        self::assertTrue($game->getStatus()->toCode() === GameStatus::GAME_STATUS_PLAYING);
        self::assertTrue($game->getTurn() == Turn::init());
    }

    /** @test */
    public function プレイヤー対戦モードの初期化()
    {
        // given
        $whitePlayer = new Player('01', '白プレイヤー');
        $blackPlayer = new Player('02', '黒プレイヤー');
        // when:
        $game = GameFactory::makeVsPlayerGame($whitePlayer, $blackPlayer);

        self::assertTrue($game->getMode() == GameMode::vsPlayerMode());
        self::assertTrue($game->getParticipants() == Participants::make($whitePlayer, $blackPlayer));
    }

    /** @test */
    public function Bot対戦モードの初期化()
    {
        // given
        $whiteBot = new BotParticipant('01', '白ボット');
        $blackPlayer = new Player('02', '黒プレイヤー');
        // when:
        $game = GameFactory::makeVsBotGame($whiteBot, $blackPlayer);

        self::assertTrue($game->getMode() == GameMode::vsBotMode());
        self::assertTrue($game->getParticipants() == Participants::make($whiteBot, $blackPlayer));
    }

    /** @test */
    public function Bot観戦モードの初期化()
    {
        // given
        $whiteBot = new BotParticipant('01', '白ボット');
        $blackBot = new BotParticipant('02', '黒ボット');
        // when:
        $game = GameFactory::makeViewingGame($whiteBot, $blackBot);

        self::assertTrue($game->getMode() == GameMode::viewingMode());
        self::assertTrue($game->getParticipants() == Participants::make($whiteBot, $blackBot));
    }
}
