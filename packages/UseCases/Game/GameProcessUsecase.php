<?php

namespace Packages\UseCases\Game;

use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\ArrayShape;
use Packages\Models\Board\Position\Position;
use Packages\Models\Game\Game;
use Packages\Repositories\Game\GameRepositoryInterface;

class GameProcessUsecase
{
    private GameRepositoryInterface $gameRepository;

    public function __construct(GameRepositoryInterface $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }


    /**
     * @param $gameId
     * @param $playerMove
     * @return array{success: bool, data: Game, message: string}
     */
    public function process($gameId, $playerMove): array
    {
        $game = $this->gameRepository->findById($gameId);
        try {
            // TODO: moveとpositionの定義が曖昧なので整理
            $movedPosition = Position::make($playerMove);
            $processedGame = $game->process($movedPosition);
            // 保存
            $this->gameRepository->save($processedGame);

            // TODO: DTO導入
            return [
                'success' => true,
                'data' => $processedGame,
                'message' => '',
                'isPlayableTurn' => !$processedGame->getTurn()->mustSkip()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => $game,
                'message' => $e->getMessage(),
            ];
        }
    }
}
