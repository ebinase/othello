<?php

namespace Packages\Factories\Game;

use Illuminate\Support\Str;
use Packages\Models\GameOrganizer\Game;
use Packages\Models\GameOrganizer\GameMode;
use Packages\Models\GameOrganizer\Participant\ParticipantInterface;
use Packages\Models\GameOrganizer\Participants;

class GameFactory
{
    public static function makeVsPlayerGame(ParticipantInterface $whiteParticipant, ParticipantInterface $blackParticipant): Game
    {
        return Game::init(
            Str::uuid(),
            GameMode::vsPlayerMode(),
            Participants::make($whiteParticipant, $blackParticipant)
        );
    }

    public static function makeVsBotGame(ParticipantInterface $whiteParticipant, ParticipantInterface $blackParticipant): Game
    {
        return Game::init(
            Str::uuid(),
            GameMode::vsBotMode(),
            Participants::make($whiteParticipant, $blackParticipant)
        );
    }

    public static function makeViewingGame(ParticipantInterface $whiteParticipant, ParticipantInterface $blackParticipant): Game
    {
        return Game::init(
            Str::uuid(),
            GameMode::viewingMode(),
            Participants::make($whiteParticipant, $blackParticipant)
        );
    }
}
