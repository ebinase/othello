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
    #[ArrayShape(['success' => "bool", 'data' => "\Packages\Models\Game\Game", 'message' => "string", 'isFinished' => "bool", 'action' => "string|null"])] public function handle($gameId): array
    {
        $game = $this->gameRepository->findById($gameId);

        if (isset($game)) {
            if ($game->getTurn()->mustSkip()) {
                $action = '01';
            } elseif ($game->isBotTurn()) {
                $action = '02';
            } else {
                $action = null;
            }

            return [
                'success' => true,
                'data' => $game,
                'message' => '',
                'isFinished' => $game->getStatus()->isFinished(),
                'action' => $action
            ];
        }

        return [
            'success' => false,
        ];
    }
}
