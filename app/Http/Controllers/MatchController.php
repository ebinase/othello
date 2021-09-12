<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatchRequest;
use Illuminate\Routing\Controller as BaseController;
use Packages\UseCases\Turn\TurnProcessUsecase;

class MatchController extends BaseController
{
    private $turnProcessUsecase;

    public function  __construct(TurnProcessUsecase $turnProcessUsecase)
    {
        $this->turnProcessUsecase = $turnProcessUsecase;
    }

    public function show()
    {
        
    }

    public function process(MatchRequest $request)
    {
        $params = $request->getProcessParams();

        $this->turnProcessUsecase->process($params);

        return redirect()->route('match.show');
    }
}
