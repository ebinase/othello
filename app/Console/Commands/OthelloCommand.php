<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Packages\Domain\Board\Board;
use Packages\Domain\Position\Position;
use Packages\Domain\Stone\Stone;

class OthelloCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:othello';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private Board $board;

    const COLOR_WHITE = 1;
    const COLOR_BLACK = 2;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $emptyRow = collect()->pad(8, 0)->toArray();
        $initBoard = [
            $emptyRow,
            $emptyRow,
            $emptyRow,
//            collect($emptyRow)->put(3, self::COLOR_WHITE)->put(4, self::COLOR_BLACK)->toArray(),
//            collect($emptyRow)->put(3, self::COLOR_BLACK)->put(4, self::COLOR_WHITE)->toArray(),
            $emptyRow,$emptyRow,$emptyRow,
            $emptyRow,
            $emptyRow,
        ];

        $this->board = new Board($initBoard);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $turn = 1;
        while (true) {
            $activeColor = $turn%2 == 1 ? self::COLOR_WHITE : self::COLOR_BLACK;

            $this->info($turn . 'ターン目');

            $view = [];
            foreach ($this->board->toArray() as $rowNum => $row){
                $view[$rowNum][] = $rowNum + 1;
                foreach ($row as $value) {
                    $view[$rowNum][] = match ($value) {
                        self::COLOR_WHITE => '◯',
                        self::COLOR_BLACK => '●',
                        default => ' ',
                    };
                }
            }

            $this->table(['', 1,2,3,4,5,6,7,8], $view);
            $this->info(($turn%2 == 1 ? '◯' : '●') . 'のターンです。');

            if ($this->board->isPlayable(new Stone($activeColor))) {
                while (true) {
                    $row = $this->ask('行を入力してください');
                    $col = $this->ask('列を入力してください');

//                    if (!$this->confirm($row . ', ' . $col . 'でよろしいですか？')) continue;

                    if (!$this->board->isValid(new Position($row, $col), new Stone($activeColor))) {
                        $this->error('その場所には置くことができません。');
                        continue;
                    }

                    break;
                }

                $this->board = $this->board->update(new Position($row, $col), new Stone($activeColor));
            } else {
                $this->confirm('置ける場所がないためスキップしました。');
            }

            $turn++;
        }
        return 0;
    }
}
