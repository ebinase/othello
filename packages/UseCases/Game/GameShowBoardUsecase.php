<?php

namespace Packages\UseCases\Game;

use JetBrains\PhpStorm\ArrayShape;
use Packages\Repositories\Game\GameRepositoryInterface;

class GameShowBoardUsecase
{
    private GameRepositoryInterface $gameRepository;

    public function __construct(GameRepositoryInterface $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    /**
     * @param $gameId
     * @return array
     */
    #[ArrayShape(['success' => "bool", 'data' => "\Packages\Models\Game\Game", 'message' => "string", 'isFinished' => "bool"])] public function handle($gameId): array
    {
        $game = $this->gameRepository->findById($gameId);

        if (isset($game)) {
            return [
                'success' => true,
                'data' => $game,
                'message' => '',
                'isFinished' => $game->getStatus()->isFinished(),
            ];
        }

        return [
            'success' => false,
        ];
    }
}
