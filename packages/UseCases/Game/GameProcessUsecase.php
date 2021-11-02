<?php

namespace Packages\UseCases\Turn;

use Illuminate\Http\JsonResponse;
use Packages\Domain\Game\GameRepositoryInterface;

class GameProcessUsecase
{
    private GameRepositoryInterface $gameRepository;

    public function __construct(GameRepositoryInterface $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function process($gameId, $playerMove): JsonResponse
    {
        $game = $this->gameRepository->find($gameId);


        $game->process($playerMove);
        // 保存
        $$this->gameRepository->save($game);

        return response()->json([
            'turn_num',
            'board',
            'next_player',
            'status' => 'playable, skip, bot_turn'
        ]);
    }

    public function botProcess($gameId, $playerMove): JsonResponse
    {
        $game = $this->gameRepository->find($gameId);


        $game->process($playerMove);
        // 保存
        $$this->gameRepository->save($game);

        return response()->json([
            'turn_num',
            'board',
            'next_player',
            'status' => 'playable, skip, bot_turn'
        ]);
    }
}
