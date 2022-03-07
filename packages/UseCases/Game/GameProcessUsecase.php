<?php

namespace Packages\UseCases\Game;

use Illuminate\Http\JsonResponse;
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

    public function process($gameId, $playerMove): Game
    {
        $game = $this->gameRepository->find($gameId);

        // TODO: moveとpositionの定義が曖昧なので整理
        $movedPosition = Position::make($playerMove);
        $processedGame = $game->process($movedPosition);
        // 保存
        $this->gameRepository->save($processedGame);

        return $processedGame;
    }
}
