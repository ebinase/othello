<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use Packages\Models\Board\Color\Color;
use Packages\UseCases\Game\GameInitializeUsecase;
use Illuminate\Routing\Controller as BaseController;
use Packages\UseCases\Game\GameProcessUsecase;
use Illuminate\Http\Request;
use Packages\UseCases\Game\GameShowBoardUsecase;

class GameController extends BaseController
{
    public function show(Request $request, GameShowBoardUsecase $showBoardUsecase)
    {
        $gameID = $request->route()->parameter('game_id');

        $result = $showBoardUsecase->handle($gameID);


        if (!$result['success']) {
            // TODO: エラー文言追加
            return redirect()->route('top');
        }

        if ($result['isFinished']) {
            return redirect()->route('game.showResult', ['game_id' => $result['data']->getId()]);
        }

        // TODO: viewModelに詰め替え
        return view('game.board', [
            'board' => $result['data']->getTurn()->getBoard()->toArray(),
            'statusMessage' => $result['data']->getTurn()->getPlayableColor()->toCode() === Color::COLOR_CODE_WHITE ? '◯' : '●',
            'action' => $result['data']->getTurn()->mustSkip() ? '01' : '',
        ]);
    }

    public function start(GameRequest $request, GameInitializeUsecase $initializeUsecase)
    {
        $gameMode = $request->route()->parameter('game_mode');
        $result = $initializeUsecase->initialize($gameMode);

        if (!$result['success']) {
            return redirect()->route('top');
        }

        return redirect()->route('game.show', ['game_id' => $result['data']->getId()]);
    }

    public function process(GameRequest $request, GameProcessUsecase $gameProcessUsecase)
    {
        $gameID = $request->input('game_id');
        $playerMove = $request->getProcessParams();

        $result = $gameProcessUsecase->process($gameID, $playerMove);
        if (!$result['success']) {
            session()->flash('error', $result['message']);
        }
        return redirect()->route('game.show', ['game_id' => $result['data']->getId()]);
    }

    public function showResult(Request $request, GameShowBoardUsecase $showBoardUsecase)
    {
        $gameID = $request->route()->parameter('game_id');

        // TODO: ユースケース作成?
        $result = $showBoardUsecase->handle($gameID);

        if (!$result['isFinished']) {
            session()->flash('error', 'まだ諦めるには早いかも');
            return redirect()->route('game.show', ['game_id' => $result['data']->getId()]);
        }

        return view('game.board', [
            'board' => $result['data']->getTurn()->getBoard()->toArray(),
            'statusMessage' => $result['data']->getWinner()?->getName() . 'の勝利！',
        ]);
    }
}
