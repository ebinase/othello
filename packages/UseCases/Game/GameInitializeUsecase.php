<?php

namespace Packages\UseCases\Game;

use Packages\Factories\Game\GameFactory;
use Packages\Models\Bot\BotFactory;
use Packages\Models\Game\Game;
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
     * @return Game
     */
    public function initializeVsPlayerGame(): Game
    {
        $whitePlayer = new Player('01', '白プレイヤー');
        $blackPlayer = new Player('02', '黒プレイヤー');
        $newGame = GameFactory::makeVsPlayerGame($whitePlayer, $blackPlayer);

        $this->gameRepository->save($newGame);
        return $newGame;
    }

    /**
     * @return Game
     */
    public function initializes(): Game
    {
        $whitePlayer = new Player('01', '白プレイヤー');
        $blackPlayer = new BotParticipant(BotFactory::BOT_ID_RANDOM, '黒プレイヤー');
        $newGame = GameFactory::makeVsBotGame($whitePlayer, $blackPlayer);

        $this->gameRepository->save($newGame);
        return $newGame;
    }

    /**
     * @return Game
     */
    public function initialize(): Game
    {
        $whitePlayer = new BotParticipant('01', '白プレイヤー');
        $blackPlayer = new BotParticipant(BotFactory::BOT_ID_RANDOM, '黒プレイヤー');
        $newGame = GameFactory::makeViewingGame($whitePlayer, $blackPlayer);

        $this->gameRepository->save($newGame);
        return $newGame;
    }
}
