<?php

namespace Packages\UseCases\Turn;

use Exception;
use Packages\Domain\Stone\Stone;
use Packages\Domain\Turn\TurnRepositoryInterface;

class TurnProcessUsecase
{
    private TurnRepositoryInterface $turnRepository;

    public function __construct(TurnRepositoryInterface $turnRepository)
    {
        $this->turnRepository = $turnRepository;
    }

    public function process($params)
    {
        $movedStone = new Stone($params['color'], $params['x'], $params['y']);

        $currentTurn = $this->turnRepository->getCurrent();

        // スキップ判定等はターンの中に隠蔽？

        $nextTurn = $currentTurn->next($movedStone);
        // 保存
        $this->turnRepository->store($nextTurn);

        // viewModelに詰め替えて返却
        return;
    }
}
