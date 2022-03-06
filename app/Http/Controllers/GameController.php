<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use Packages\UseCases\Game\GameInitializeUsecase;
use Illuminate\Routing\Controller as BaseController;
use Packages\UseCases\Game\GameProcessUsecase;

class GameController extends BaseController
{
    public function index()
    {
        return 'hoge';
    }

    public function start(GameInitializeUsecase $initializeUsecase)
    {
        $game = $initializeUsecase->initialize();
        // todo: viewModelに詰め替え
        return view('game.board', ['board' => $game->getTurn()->getBoard()->toArray()]);
    }

    public function process(GameRequest $request, GameProcessUsecase $gameProcessUsecase)
    {
        $gameID = $request->session()->get('game_id');
        list($x, $y) = $request->getProcessParams();
        $playerMove = [$x, $y];

        $processedGame = $gameProcessUsecase->process($gameID, $playerMove);

        return view('game.board', ['board' => $processedGame->getTurn()->getBoard()->toArray()]);
    }
}
