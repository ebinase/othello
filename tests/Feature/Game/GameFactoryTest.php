<?php

namespace Tests\Feature\Game;

use Packages\Factories\Game\GameFactory;
use Packages\Models\Game\Game;
use Packages\Models\Game\GameMode;
use Packages\Models\Game\GameStatus;
use Packages\Models\Game\Participants;
use Packages\Models\Player\Player;
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
        /**@var Game $game*/
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
        /**@var Game $game*/
        $game = GameFactory::makeVsPlayerGame($whitePlayer, $blackPlayer);

        self::assertTrue($game->getMode() == GameMode::vsPlayerMode());
        self::assertTrue($game->getParticipants() == Participants::make($whitePlayer, $blackPlayer));
    }
}
