<?php

namespace Tests\Feature\Game;

use Packages\Models\Board\Board;
use Packages\Models\Board\Color\Color;
use Packages\Models\Board\Position\Position;
use Packages\Models\Common\Matrix\Matrix;
use Packages\Models\Game\Game;
use Packages\Models\Game\GameMode;
use Packages\Models\Game\GameStatus;
use Packages\Models\Game\Participants;
use Packages\Models\Player\Player;
use Packages\Models\Turn\Turn;
use Tests\TestCase;

class GameProcessTest extends TestCase
{
    /** @test */
    public function 正常なゲームの進行()
    {
        // given:
        $gameId = 'hoge';
        $mode = GameMode::vsPlayerMode();
        $whitePlayer = new Player('01', 'player_white');
        $blackPlayer = new Player('02', 'player_black');
        $participants = Participants::make($whitePlayer, $blackPlayer);

        $game = Game::init($gameId, $mode, $participants);
        $move = Position::make([4, 6]); // 先行プレイヤーが1ターン目に指す場所
        // when:
        $game->process($move);

        // then:
        self::assertSame($gameId, $game->getId());
        self::assertSame(true, $mode == $game->getMode());
        self::assertSame(true, $participants == $game->getParticipants());
        self::assertSame(true, GameStatus::GAME_STATUS_PLAYING == $game->getStatus()->toCode());
        // 2ターン目のターン情報のチェック
        $turn = $game->getTurn();
        $boardAtSecondTurn = Board::init()->update($move, Color::white());
        self::assertSame(2, $turn->getTurnNumber());
        self::assertSame(true, Color::black()->equals($turn->getPlayableColor()));
        self::assertSame(true, $boardAtSecondTurn->equals($turn->getBoard()));
        self::assertSame(0, $turn->getSkipCount(), 'スキップカウントは0');
    }

    /** @test */
    public function ゲームを進行させる場合はステータスがプレー中でなくてはいけない()
    {
        // given:
        // TODO: 条件が不明瞭なので精査
        $gameId = 'hoge';
        $mode = GameMode::vsPlayerMode();
        $whitePlayer = new Player('01', 'player_white');
        $blackPlayer = new Player('02', 'player_black');
        $participants = Participants::make($whitePlayer, $blackPlayer);
        $status = GameStatus::finish();
        $turn = Turn::init();

        $game = Game::make($gameId, $mode, $participants, $status, $turn);

        // when:
        // then:
        $move = Position::make([4, 6]); // 先行プレイヤーが1ターン目に指す場所
        $this->expectException(\RuntimeException::class);
        $game->process($move);

    }
}
