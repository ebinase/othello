<?php

namespace Packages\Models\Core\Action;

class Action
{
    private function __construct(
        public readonly ActionType $actionType,
        public readonly mixed $data,
    )
    {
        if (!$this->actionType->checkDataType($this->data)) {
            throw new \DomainException("データ形式が異なります。");
        }
    }

    public static function make(ActionType $actionType, mixed $data = null)
    {
        return new self($actionType, $data);
    }

    public function getData()
    {
        return $this->data;
    }
}
