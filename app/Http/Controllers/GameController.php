<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use Packages\Domain\Position\Position;
use Packages\UseCases\Turn\GameProcessUsecase;
use Illuminate\Routing\Controller as BaseController;

class GameController extends BaseController
{
    private $turnProcessUsecase;

    public function  __construct(GameProcessUsecase $turnProcessUsecase)
    {
        $this->turnProcessUsecase = $turnProcessUsecase;
    }

    public function show()
    {
        
    }

    public function process(GameRequest $request)
    {
        $gameID = $request->session()->get('game_id');
        $params = $request->getProcessParams();

        $playerMove = new Position($params['x'], $params['y']);

        $this->turnProcessUsecase->process($gameID, $playerMove);

        return redirect()->route('match.show');
    }
}
