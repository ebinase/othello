<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Packages\Domain\Board\Board;
use Packages\Domain\Bot\Strategies\Random\RandomBot;
use Packages\Domain\Color\Color;
use Packages\Domain\Common\Position\PositionConverterTrait;
use Packages\Domain\Player\BotPlayer;
use Packages\Domain\Player\Player;
use Packages\Domain\Player\PlayerInterface;

class OthelloCommand extends Command
{
    use PositionConverterTrait;

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

    // ---------------------------------------
    // 設定値
    // ---------------------------------------
    const COLOR_WHITE = 1;
    const COLOR_BLACK = 2;

    const MODE_PVP = '01';
    const MODE_BOT = '02';

    // ---------------------------------------
    // データ永続化
    // ---------------------------------------
    private string $gameMode;

    private Board $board;

    private PlayerInterface $whitePlayer;
    private PlayerInterface $blackPlayer;

    /**
     * @var PlayerInterface[]
     */
    private array $playerList;

    private static array $botList = [
        1 => [1, 'さいじゃく', 'わざと負けるBot'],
        2 => [2, 'よわい', 'ランダムボット'],
        3 => [3, 'そこそこ', '開放度ボット'],
        4 => [4, '強め', '先読みボット'],
        5 => [5, '強め', '戦況分析ボット'],
    ];

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
            collect($emptyRow)->put(3, self::COLOR_WHITE)->put(4, self::COLOR_BLACK)->toArray(),
            collect($emptyRow)->put(3, self::COLOR_BLACK)->put(4, self::COLOR_WHITE)->toArray(),
            $emptyRow,
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
//        if ($this->confirm('Bot対戦を行いますか？', true)) {
//            $this->gameMode = self::MODE_BOT;
//
//            $this->info('対戦するボットを選んでください。');
//            $this->table(['id', '強さ', '名前'], self::$botList);
//            $id = $this->ask('id');
//
//
//            $choice = $this->choice("プレー順を選んでください", [1 => 'プレイヤー先攻', 2 => 'Bot先攻'], 1);
//            if ($choice === 'プレイヤー先攻') {
//                $this->whitePlayer = new Player('01', 'player_01');
//                $this->blackPlayer = new BotPlayer('02', 'player_02');
//            } else {
//                $this->whitePlayer = new BotPlayer('01', 'player_01');
//                $this->blackPlayer = new Player('02', 'player_02');
//            }
//        } else {
//            $this->gameMode = self::MODE_PVP;
//            $this->whitePlayer = new Player('01', 'player_01');
//            $this->blackPlayer = new Player('02', 'player_02');
//        }

        $this->playerList = [
            self::COLOR_WHITE => new BotPlayer('01', 'player_01'),
            self::COLOR_BLACK => new BotPlayer('02', 'player_02'),
        ];

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

            if (!$this->board->isPlayable(Color::make($activeColor))) {
                $this->confirm('置ける場所がないためスキップします。', true);
            } else {
                // ボットのターンか判定
                if ($this->playerList[$activeColor]->isBot()) {
                    $this->info('Bot思考中・・・');

                    $bot = new RandomBot(Color::make($activeColor), $this->board);

                    $bar = $this->output->createProgressBar(10);
                    $bar->start();
                    $count = 1;
                    while ($count <= 10) {
                        if ($count === 5) {
                            $action = $bot->culculate();
                        }
                        usleep(50000);
                        $bar->advance();
                        $count++;
                    }
                    $bar->finish();
                    echo "\n\n\n";
                    $action = $this->toMatrixPosition($action);
                    $this->error($action[0] . ',' . $action[1]);
                    $this->confirm('確認した', true);

                } else {
                    while (true) {
                        $row = $this->ask('行を入力してください');
                        $col = $this->ask('列を入力してください');

                        if (!$this->board->isValid([$row, $col], Color::make($activeColor))) {
                            $this->error('その場所には置くことができません。');
                            continue;
                        }
                        break;
                    }
                    $action = [$row, $col];
                }

                $this->board = $this->board->update($action, Color::make($activeColor));
            }

            $turn++;
//            echo "\033[2J";
        }
        return 0;
    }
}
