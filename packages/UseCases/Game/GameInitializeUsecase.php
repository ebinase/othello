<?php

namespace Packages\UseCases\Game;

use Packages\Factories\Game\GameFactory;
use Packages\Models\Bot\BotFactory;
use Packages\Models\Game\Game;
use Packages\Models\Game\GameMode;
use Packages\Models\Participant\BotParticipant;
use Packages\Models\Participant\Player;
use Packages\Repositories\Game\GameRepositoryInterface;

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
                $blackPlayer = new BotParticipant(BotFactory::BOT_ID_RANDOM, '黒プレイヤー');
                $newGame = GameFactory::makeVsBotGame($whitePlayer, $blackPlayer);
            } else {
                $whitePlayer = new BotParticipant('01', '白プレイヤー');
                $blackPlayer = new BotParticipant(BotFactory::BOT_ID_RANDOM, '黒プレイヤー');
                $newGame = GameFactory::makeViewingGame($whitePlayer, $blackPlayer);
            }

            $this->gameRepository->save($newGame);

            return ['success' => true, 'data' => $newGame];
        } catch (\Exception $e) {
            return ['success' => false, 'data' => null, 'message' => $e->getMessage()];
        }
    }
}
