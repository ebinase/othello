<?php

namespace Packages\Models\GameOrganizer\Participant;

class BaseParticipant implements ParticipantInterface
{
    private string $id;
    private string $name;
    private string $type;

    public function __construct($id, $name, $type)
    {
        $this->id   = $id;
        $this->type = $type;
        $this->name = $name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPlayerType(): string
    {
        return $this->type;
    }

    public function isBot(): bool
    {
        return $this->type === self::PARTICIPANT_TYPE_BOT;
    }

    public function isPlayer(): bool
    {
        return $this->type === self::PARTICIPANT_TYPE_PLAYER;
    }

    public function equals(ParticipantInterface $participant): bool
    {
        $this->id === $participant->getId();
    }
}
