<?php

namespace Packages\UseCases\Game;

use Packages\Models\Bot\BotType;
use Packages\Models\GameOrganizer\Game;
use Packages\Models\GameOrganizer\GameFactory;
use Packages\Models\GameOrganizer\GameMode;
use Packages\Models\GameOrganizer\GameRepositoryInterface;
use Packages\Models\GameOrganizer\Participant\BotParticipant;
use Packages\Models\GameOrganizer\Participant\Player;

class GameInitializeUsecase
{
    private GameRepositoryInterface $gameRepository;

    public function __construct(GameRepositoryInterface $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    /**
     * @param string $gameMode
     * @return Game
     */
    public function initialize(string $gameMode): array
    {
        try {
            $gameMode = GameMode::make($gameMode);

            // TODO: この辺のインターフェースをもっと簡素に
            // TODO: 参加者名の変更や、先攻後攻を選べるようにする
            if ($gameMode->isVsPlayerMode()) {
                $whitePlayer = new Player('01', '白プレイヤー');
                $blackPlayer = new Player('02', '黒プレイヤー');
                $newGame = GameFactory::makeVsPlayerGame($whitePlayer, $blackPlayer);
            } elseif ($gameMode->isVsBotMode()) {
                $whitePlayer = new Player('01', '白プレイヤー');
                $blackPlayer = new BotParticipant(BotType::SELF_OPENNESS->value, '黒プレイヤー');
                $newGame = GameFactory::makeVsBotGame($whitePlayer, $blackPlayer);
            } else {
                $whitePlayer = new BotParticipant(BotType::RANDOM->value, 'ランダムボット');
                $blackPlayer = new BotParticipant(BotType::SELF_OPENNESS->value, '周辺開放度ボット');
                $newGame = GameFactory::makeViewingGame($whitePlayer, $blackPlayer);
            }

            $this->gameRepository->save($newGame);

            return ['success' => true, 'data' => $newGame];
        } catch (\Exception $e) {
            return ['success' => false, 'data' => null, 'message' => $e->getMessage()];
        }
    }
}
