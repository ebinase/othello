<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use Packages\UseCases\Turn\GameProcessUsecase;
use Illuminate\Routing\Controller as BaseController;

class GameController extends BaseController
{

    public function index()
    {
        return 'hoge';
    }

    public function start()
    {
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
