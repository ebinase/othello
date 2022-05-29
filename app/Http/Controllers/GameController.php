<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Packages\Models\Core\Board\Color\Color;
use Packages\UseCases\Game\GameInitializeUsecase;
use Packages\UseCases\Game\GameProcessUsecase;
use Packages\UseCases\Game\GameShowBoardUsecase;

class GameController extends BaseController
{
    public function show(Request $request, GameShowBoardUsecase $showBoardUsecase)
    {
        $gameID = $request->route()->parameter('game_id');

        $result = $showBoardUsecase->handle($gameID);


        if (!$result['success']) {
            // TODO: エラー文言追加
            return to_route('top');
        }

        if ($result['isFinished']) {
            return to_route('game.showResult', ['game_id' => $result['data']->getId()]);
        }

        // TODO: viewModelに詰め替え
        return view('game.board', [
            'board' => $result['data']->getTurn()->getBoard()->toArray(),
            'statusMessage' => $result['data']->getTurn()->getPlayableColor()->toCode() === Color::COLOR_CODE_WHITE ? '◯' : '●',
            'action' => $result['action'], // TODO: ユーザーイベント発行とかにする
        ]);
    }

    public function start(GameRequest $request, GameInitializeUsecase $initializeUsecase)
    {
        $gameMode = $request->route()->parameter('game_mode');
        $result = $initializeUsecase->initialize($gameMode);

        if (!$result['success']) {
            return to_route('top');
        }

        return to_route('game.show', ['game_id' => $result['data']->getId()]);
    }

    public function process(GameRequest $request, GameProcessUsecase $gameProcessUsecase)
    {
        $gameID = $request->input('game_id');
        $playerMove = $request->getProcessParams();

        $result = $gameProcessUsecase->handle($gameID, $playerMove);

        if (!$result['success']) {
            session()->flash('error', $result['message']);
        }
        return to_route('game.show', ['game_id' => $result['data']->getId()]);
    }

    public function showResult(Request $request, GameShowBoardUsecase $showBoardUsecase)
    {
        $gameID = $request->route()->parameter('game_id');

        // TODO: ユースケース作成?
        $result = $showBoardUsecase->handle($gameID);

        if (!$result['isFinished']) {
            session()->flash('error', 'まだ諦めるには早いかも');
            return to_route('game.show', ['game_id' => $result['data']->getId()]);
        }

        $winner = $result['data']->getWinner();

        return view('game.board', [
            'board' => $result['data']->getTurn()->getBoard()->toArray(),
            'statusMessage' => !empty($winner) ? $winner->getName() . 'の勝利！' : '引き分け！',
            'action' => null
        ]);
    }
}
