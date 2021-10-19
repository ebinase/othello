<?php

namespace Packages\UseCases\Turn;

use Packages\Domain\Game\GameRepositoryInterface;

class GameProcessUsecase
{
    private GameRepositoryInterface $gameRepository;

    public function __construct(GameRepositoryInterface $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function process($gameId, $playerMove)
    {
        $game = $this->gameRepository->find($gameId);

        $game->process($playerMove);
        // 保存
        $$this->gameRepository->save($game);

        // viewModelに詰め替えて返却
        return;
    }
}
