<?php

namespace Packages\Models\Core\Action;

use Packages\Models\Core\Board\Position\Position;

enum ActionType: string
{
    case SET_STONE = '01';
    case CONFIRM_SKIP = '02';

    public function requireData(): bool
    {
        return is_null($this->dataType());
    }

    public function checkDataType(mixed $data): bool
    {
        return match ($this) {
            self::SET_STONE => $data instanceof Position,
            self::CONFIRM_SKIP => is_null($data),
        };
    }
}
