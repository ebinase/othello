<?php

namespace Packages\UseCases\Game;

use Packages\Models\GameOrganizer\Game;
use Packages\Models\Othello\Board\Position\Position;
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
    public function handle($gameId, $playerMove): array
    {
        $game = $this->gameRepository->findById($gameId);
        try {
            // TODO: moveとpositionの定義が曖昧なので整理
            $movedPosition = !empty($playerMove) ? Position::make($playerMove) : null;
            $processedGame = $game->process($movedPosition);
            // 保存
            $this->gameRepository->save($processedGame);

            // TODO: DTO導入
            return [
                'success' => true,
                'data' => $processedGame,
                'message' => '',
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
