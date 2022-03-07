<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use Packages\Models\Board\Color\Color;
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
        $gameID = $request->route()->parameter('game_id');
        $game = $gameRepository->findById($gameID);
        // TODO: viewModelに詰め替え
        return view('game.board', [
            'board' => $game->getTurn()->getBoard()->toArray(),
            'activeColor' => $game->getTurn()->getPlayableColor()->toCode() === Color::COLOR_CODE_WHITE ? '◯' : '●',
        ]);
    }

    public function start(GameInitializeUsecase $initializeUsecase)
    {
        $game = $initializeUsecase->initialize();

        return redirect()->route('game.show', ['game_id' => $game->getId()]);
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
}
