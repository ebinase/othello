<?php

namespace Packages\Models\Core\Othello;

use Illuminate\Support\Str;
use Packages\Exceptions\DomainException;
use Packages\Models\Core\Action\Action;
use Packages\Models\Core\Action\ActionType;
use Packages\Models\Core\Turn\Turn;

class Othello
{
    private function __construct(
        public readonly string $id,
        private Status $status,
        private Turn $turn,
    ) {
        if (!Str::isUuid($id)) throw new DomainException();
    }

    public static function init(): Othello
    {
        return new self(
            id:     Str::uuid(),
            status: Status::PLAYING,
            turn:   Turn::init(),
        );
    }

    public static function make(string $id, Status $status, Turn $turn): self
    {
        return new self(
            id:     $id,
            status: $status,
            turn:   $turn,
        );
    }

    /**
     * ゲームの状態更新
     */
    public function apply(Action $action): void
    {
        // プレー中ではない場合
        if ($this->status !== Status::PLAYING) throw new DomainException();

        $turnBefore = $this->turn;
        // ターンを更新する
        $this->turn = match ($action->actionType) {
            ActionType::SET_STONE => $this->turn->advance($action->data),
            ActionType::CONFIRM_SKIP => $this->turn->skip(),
        };

        $this->status = $this->nextStatus($turnBefore, $this->turn);
    }

    private function nextStatus(Turn $turnBefore, Turn $turnAfter): Status
    {
        if ($turnAfter->isLast()) return $this->status = Status::RESULTED;
        if (self::mustInterrupt($turnBefore, $turnAfter)) return $this->status = Status::INTERRUPTED;

        return Status::PLAYING;
    }

    private static function mustInterrupt(Turn $turnBefore, Turn $turnAfter)
    {
        return $turnBefore->mustSkip() && $turnAfter->mustSkip();
    }

    /**
     * ゲームが終了しているか判定する
     * 正常終了、スキップによる異常終了なのかは問わない
     *
     * @return bool
     */
    public function isOver(): bool
    {
        // ターンが進行不可(正常系)、もしくはスキップが連続してどちらも置く場所がなくなった(異常系)場合、終了
        return !$this->turn->isLast();
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @return Turn
     */
    public function getTurn(): Turn
    {
        return $this->turn;
    }

}
