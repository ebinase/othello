<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use Packages\Repositories\Game\GameRepositoryInterface;
use Packages\UseCases\Game\GameInitializeUsecase;
use Illuminate\Routing\Controller as BaseController;
use Packages\UseCases\Game\GameProcessUsecase;
use Illuminate\Http\Request;

class GameController extends BaseController
{
    public function index()
    {
        return 'hoge';
    }

    public function show(Request $request, GameRepositoryInterface $gameRepository)
    {
        // FIXME: いったん表示用としてrepositoryをそのまま使用中
        $gameID = $request->input('game_id');
        $game = $gameRepository->find($gameID);
        // TODO: viewModelに詰め替え
        return view('game.board', ['board' => $game->getTurn()->getBoard()->toArray()]);
    }

    public function start(GameInitializeUsecase $initializeUsecase)
    {
        $game = $initializeUsecase->initialize();

        return redirect()->route('game.show', ['game_id' => $game->getId()]);
    }

    public function process(GameRequest $request, GameProcessUsecase $gameProcessUsecase)
    {
        $gameID = $request->input('game_id');
        list($x, $y) = $request->getProcessParams();
        $playerMove = [$x, $y];

        $processedGame = $gameProcessUsecase->process($gameID, $playerMove);

        return redirect()->route('game.show', ['game_id' => $processedGame->getId()]);
    }
}
