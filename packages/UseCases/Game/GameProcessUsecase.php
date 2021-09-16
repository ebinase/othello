<?php

namespace Packages\UseCases\Turn;

use Packages\Domain\Stone\Stone;
use Packages\Domain\Game\GameRepositoryInterface;

class GameProcessUsecase
{
    private GameRepositoryInterface $gameRepository;

    public function __construct(GameRepositoryInterface $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function process($gameId, $params)
    {
        $movedStone = new Stone($params['color'], $params['x'], $params['y']);

        $game = $this->gameRepository->find($gameId);

        $game->process($movedStone);
        // 保存
        $this->gameRepository->save($game);

        // viewModelに詰め替えて返却
        return;
    }
}
