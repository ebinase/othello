<?php

namespace Packages\Factories\Game;

use Illuminate\Support\Str;
use Packages\Models\Game\Game;
use Packages\Models\Game\GameMode;
use Packages\Models\Game\Participants;
use Packages\Models\Participant\ParticipantInterface;

class GameFactory
{
    public static function makeVsPlayerGame(ParticipantInterface $whitePlayer, ParticipantInterface $blackPlayer): Game
    {
        return Game::init(
            Str::uuid(),
            GameMode::vsPlayerMode(),
            Participants::make($whitePlayer, $blackPlayer)
        );
    }

    public static function makeVsBotGame(ParticipantInterface $whitePlayer, ParticipantInterface $blackPlayer): Game
    {
        return Game::init(
            Str::uuid(),
            GameMode::vsBotMode(),
            Participants::make($whitePlayer, $blackPlayer)
        );
    }

    public static function makeViewingGame(ParticipantInterface $whitePlayer, ParticipantInterface $blackPlayer): Game
    {
        return Game::init(
            Str::uuid(),
            GameMode::viewingMode(),
            Participants::make($whitePlayer, $blackPlayer)
        );
    }
}
