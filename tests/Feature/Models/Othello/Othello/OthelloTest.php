<?php

namespace Tests\Feature\Models\Othello\Othello;

use Packages\Exceptions\DomainException;
use Packages\Models\Core\Board\Color\Color;
use Packages\Models\Core\Othello\Othello;
use Packages\Models\Core\Othello\Status;
use Packages\Models\Core\Turn\Turn;
use Tests\Mock\Models\Othello\Action\ActionMock;
use Tests\Mock\Models\Othello\Board\FulfilledBoard;
use Tests\Mock\Models\Othello\Board\OneLastActionBoard;
use Tests\Mock\Models\Othello\Board\SkipBoardMock;
use Tests\TestCase;

class OthelloTest extends TestCase
{
    /** @test */
    public function オセロ初期化()
    {
        // when:
        $othello = Othello::init();

        // then:
        self::assertTrue(\Str::isUuid($othello->id));
        self::assertSame(Status::PLAYING, $othello->getStatus(), '初期状態はプレー中');
        // 下記の値はそのまま設定される
        self::assertTrue(Turn::init() == $othello->getTurn());
    }

    /** @test */
    public function プレー中の場合はゲームを進めることができる()
    {
        // given:
        $othello = Othello::init();
        $turn = $othello->getTurn();

        // when:
        $action = ActionMock::setStone();
        $othello->apply($action); // プレーを進める

        // then:
        self::assertSame(Status::PLAYING, $othello->getStatus());
        self::assertTrue($turn->advance($action->getData()) == $othello->getTurn());

    }

    /** @test */
    public function スキップせざるを得ないのにコマを置こうとした時は例外を出す()
    {
        // given:
        $othello = Othello::make(
            \Str::uuid(),
            Status::PLAYING,
            Turn::make(1, Color::white(), SkipBoardMock::get()),
        );
        // when:
        $action = ActionMock::setStone(); // おけない場所
        // then:
        $this->expectException(DomainException::class);
        $othello->apply($action);
    }

    /** @test */
    public function 置ける場所があるのにスキップしようとした場合は例外を出す()
    {
        // given:
        $othello = Othello::init(); // 1ターン目
        // when:
        $skipAction = ActionMock::skip();
        // then:
        $this->expectException(DomainException::class);
        // 置ける場所があるのに場所指定なしで更新した場合
        $othello->apply($skipAction);
    }

    /** @test */
    public function ゲームが終了しているのに進めようとしたら例外を出す()
    {
        // given:
        $interruptedOthello = Othello::make(
            \Str::uuid(),
            Status::INTERRUPTED,
            Turn::make(1, Color::white(), FulfilledBoard::get()),
        );
        $resultedOthello = Othello::make(
            \Str::uuid(),
            Status::RESULTED,
            Turn::make(1, Color::white(), FulfilledBoard::get()),
        );
        // then:
        self::expectException(DomainException::class);
        $interruptedOthello->apply(ActionMock::setStone());
        $interruptedOthello->apply(ActionMock::skip());
        $resultedOthello->apply(ActionMock::setStone());
        $resultedOthello->apply(ActionMock::skip());
    }

    // ---------------------------------------
    // 終了条件系
    // ---------------------------------------
    /** @test */
    public function 盤面に空いているマスがなくなったら終了()
    {
        // when:
        $othello = Othello::make(
            \Str::uuid(),
            Status::PLAYING,
            Turn::make(1, Color::white(), OneLastActionBoard::get8行8列に白を置くとすべて埋まる盤面()),
        );
        // then:
        $othello->apply(ActionMock::setStone(8, 8));
        self::assertSame(Status::RESULTED, $othello->getStatus());
    }

    /** @test */
    public function スキップが2ターン続いたら終了()
    {
        // given:
        // when:
        // 両者ともスキップしかできない盤面
        $othello = Othello::make(
            \Str::uuid(),
            Status::PLAYING,
            Turn::make(1, Color::white(), SkipBoardMock::白を4行5列に置くと両色ともスキップせざるを得なくなる盤面()),
        );
        // then:
        self::assertSame(Status::PLAYING, $othello->getStatus(), 'このターンはプレー中');
        // 白の行動
        $othello->apply(ActionMock::setStone(4, 5));
        self::assertSame(Status::PLAYING, $othello->getStatus(), '白がコマを置くと黒にスキップを強制');
        // 黒がスキップ
        $othello->apply(ActionMock::skip());
        self::assertSame(Status::INTERRUPTED, $othello->getStatus(), '黒がスキップした後、白もスキップせざるを得なくなるため試合終了');
    }

}
