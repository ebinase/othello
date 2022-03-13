<?php

namespace Packages\UseCases\Game;

use Packages\Factories\Game\GameFactory;
use Packages\Models\Game\Game;
use Packages\Models\Player\Player;
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
    public function initialize(): Game
    {
        $whitePlayer = new Player('01', '白プレイヤー');
        $blackPlayer = new Player('02', '黒プレイヤー');
        $newGame = GameFactory::makeVsPlayerGame($whitePlayer, $blackPlayer);

        $this->gameRepository->save($newGame);
        return $newGame;
    }
}
