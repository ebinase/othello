<?php

namespace Packages\UseCases\Game;

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
    public function handle($gameId): array
    {
        try {
            $game = $this->gameRepository->findById($gameId);
            // TODO: DTO導入
            return [
                'success' => true,
                'data' => $game,
                'message' => '',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => $e->getMessage(),
            ];
        }
    }
}
