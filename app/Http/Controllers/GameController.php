<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
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
        $id = $request->session()->get('game_id');
        $params = $request->getProcessParams();

        $this->turnProcessUsecase->process($id, $params);

        return redirect()->route('match.show');
    }
}
