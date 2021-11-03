<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Packages\Domain\Board\Board;
use Packages\Domain\Bot\BotFactory;
use Packages\Domain\Bot\BotList;
use Packages\Domain\Bot\Levels\BotLevel;
use Packages\Domain\Bot\Levels\LevelFactory;
use Packages\Domain\Bot\Calculators\Random\RandomCalculator;
use Packages\Domain\Color\Color;
use Packages\Domain\Common\Position\PositionConverterTrait;
use Packages\Domain\Player\BotPlayer;
use Packages\Domain\Player\NormalPlayer;
use Packages\Domain\Player\PlayerInterface;
use Packages\Domain\Turn\Turn;

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
    const MODE_VS_BOT = '02';
    const MODE_BOT_ONLY = '03';

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

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();


    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $gameMode = $this->choice("ゲームモードを選択してください。", [1 => 'プレイヤー対戦', 2 => 'Bot対戦', 3 => 'Bot対Bot(観戦)'], 1);
        if ($gameMode === '1') {
            $this->gameMode = self::MODE_PVP;
            $this->whitePlayer = new NormalPlayer('01', 'player_01');
            $this->blackPlayer = new NormalPlayer('02', 'player_02');
        } elseif ($gameMode === '2') {
            $this->gameMode = self::MODE_VS_BOT;

            $this->info('対戦するボットを選んでください。');

            $this->table(['id', '強さ', '名前'], [[BotFactory::BOT_ID_RANDOM, LevelFactory::BOT_LEVEL_DESCRIPTION_01, 'ランダムボット']]);
            $id = $this->ask('id');

            $choice = $this->choice("プレー順を選んでください", [1 => 'プレイヤー先攻', 2 => 'Bot先攻'], 1);
            if ($choice === 'プレイヤー先攻') {
                $this->whitePlayer = new NormalPlayer('01', 'player_01');
                $this->blackPlayer = new BotPlayer('02', 'player_02', $id);
            } else {
                $this->whitePlayer = new BotPlayer('01', 'player_01');
                $this->blackPlayer = new NormalPlayer('02', 'player_02', $id);
            }
        } else {
            $this->info('対戦するボットを選んでください。');

            $this->table(['id', '強さ', '名前'], [[BotFactory::BOT_ID_RANDOM, LevelFactory::BOT_LEVEL_DESCRIPTION_01, 'ランダムボット']]);
            $id = $this->ask('id');

            $this->playerList = [
                self::COLOR_WHITE => new BotPlayer('01', 'player_01', $id),
                self::COLOR_BLACK => new BotPlayer('02', 'player_02', $id),
            ];
        }

        $this->board = Board::init();

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
                $activePlayer = $this->playerList[$activeColor];
                if ($activePlayer->isBot()) {
                    $this->info('Bot思考中・・・');

//                    $activePlayer->getPlayerType();
                    $turnObj = new Turn($turn, Color::make($activeColor), $this->board, 0);
                    $bot = BotFactory::make($id, $turnObj);

                    $bar = $this->output->createProgressBar(10);
                    $bar->start();
                    $count = 1;
                    while ($count <= 10) {
                        if ($count === 5) {
                            $action = $bot->execute();
                        }
//                        usleep(50000);
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

            info($this->board->getRest());
            if ($this->board->getRest() == 0) {
                break;
            }
        }
        $whitePoint = $this->board->getPoint(Color::white());
        $blackPoint = $this->board->getPoint(Color::black());
        info( "◯：$whitePoint 対 ●：$blackPoint");
        echo $whitePoint > $blackPoint ? '◯の勝ち' : '●の勝ち';
        return 0;
    }
}
