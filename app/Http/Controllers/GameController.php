<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use Packages\UseCases\Game\GameInitializeUsecase;
use Illuminate\Routing\Controller as BaseController;

class GameController extends BaseController
{
    private GameInitializeUsecase $initializeUsecase;

    public function __construct()
    {
        $this->initializeUsecase = new GameInitializeUsecase();
    }

    public function index()
    {
        return 'hoge';
    }

    public function start()
    {
        $game = $this->initializeUsecase->initialize();
        // todo: viewModelに詰め替え
        return view('game.start', ['board' => $game->getTurn()->getBoard()->toArray()]);
    }

    public function process(GameRequest $request)
    {
        $gameID = $request->session()->get('game_id');
        $params = $request->getProcessParams();

        $playerMove = [$params['x'], $params['y']];

        $this->turnProcessUsecase->process($gameID, $playerMove);

        return redirect()->route('game.show');
    }
}
