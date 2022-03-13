<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Packages\Models\Board\Board;
use Packages\Models\Board\Position\Position;
use Packages\Models\Board\Position\PositionConverterTrait;
use Packages\Models\Bot\BotFactory;
use Packages\Models\Bot\Levels\LevelFactory;
use Packages\Models\Board\Color\Color;
use Packages\Models\Participant\BotParticipant;
use Packages\Models\Participant\Player;
use Packages\Models\Participant\ParticipantInterface;
use Packages\Models\Turn\Turn;

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
    const MODE_PVP = '01';
    const MODE_VS_BOT = '02';
    const MODE_BOT_ONLY = '03';

    // ---------------------------------------
    // データ永続化
    // ---------------------------------------
    private string $gameMode;

    private ParticipantInterface $whitePlayer;
    private ParticipantInterface $blackPlayer;

    /**
     * @var ParticipantInterface[]
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
        if ($gameMode === 'プレイヤー対戦') {
            $this->gameMode = self::MODE_PVP;
            $this->playerList = [
                Color::white()->toCode() => new Player('01', 'player_01'),
                Color::black()->toCode() => new Player('02', 'player_02'),
            ];
        } elseif ($gameMode === 'Bot対戦') {
            $this->gameMode = self::MODE_VS_BOT;

            $this->info('対戦するボットを選んでください。');

            $this->table(['id', '強さ', '名前'], [[BotFactory::BOT_ID_RANDOM, LevelFactory::BOT_LEVEL_DESCRIPTION_01, 'ランダムボット']]);
            $id = $this->ask('id');

            $choice = $this->choice("プレー順を選んでください", [1 => 'プレイヤー先攻', 2 => 'Bot先攻'], 1);
            if ($choice === 'プレイヤー先攻') {
                $this->playerList = [
                    Color::white()->toCode() => new Player('01', 'player_01'),
                    Color::black()->toCode() => new BotParticipant('02', 'player_02', $id),
                ];
            } else {
                $this->playerList = [
                    Color::white()->toCode() => new BotParticipant('01', 'player_01', $id),
                    Color::black()->toCode() => new Player('02', 'player_02'),
                ];
            }
        } else {
            $this->info('対戦するボットを選んでください。');

            $this->table(['id', '強さ', '名前'], [[BotFactory::BOT_ID_RANDOM, LevelFactory::BOT_LEVEL_DESCRIPTION_01, 'ランダムボット']]);
            $id = $this->ask('id');

            $this->playerList = [
                Color::white()->toCode() => new BotParticipant('01', 'player_01', $id),
                Color::black()->toCode() => new BotParticipant('02', 'player_02', $id),
            ];
        }

        $turn = Turn::init();
        while (!$turn->finishedLastTurn() && $turn->isContinuable()) { // 最終ターンが終了しておらず、プレイが継続可能な状態の時
            $this->info($turn->getTurnNumber() . 'ターン目');

            $this->renderBoard($turn->getBoard());
            $this->info(($turn->getTurnNumber() % 2 == 1 ? '◯' : '●') . 'のターンです。');

            // スキップの場合はすぐにcontinue
            if ($turn->mustSkip()) {
                $this->confirm('置ける場所がないためスキップします。', true);
                $turn = $turn->next();
                continue;
            }

            // ボットのターンか判定
            $activePlayer = $this->playerList[$turn->getPlayableColor()->toCode()];
            if ($activePlayer->isBot()) {
                $this->info('Bot思考中・・・');

                $bot = BotFactory::make($id, $turn);

                $bar = $this->output->createProgressBar(10);
                $bar->start();
                $count = 1;
                while ($count <= 10) {
//                        usleep(50000);
                    $bar->advance();
                    $count++;
                }
                $bar->finish();
                echo "\n\n\n";

                $action = $bot->execute();
                $this->error($action->toMatrixPosition()[0] . ',' . $action->toMatrixPosition()[1]);
                $this->confirm('確認した', true);

            } else {
                while (true) {
                    $row = $this->ask('行を入力してください');
                    $col = $this->ask('列を入力してください');

                    if (empty($row) || empty($col)) continue;

                    if (!$turn->getBoard()->isValid(Position::make([$row, $col]), $turn->getPlayableColor())) {
                        $this->error('その場所には置くことができません。');
                        continue;
                    }
                    break;
                }
                $action = Position::make([$row, $col]);
            }

            $turn = $turn->next($action);
        } // while()

        $this->error('=====================================');
        $this->error('==           ゲーム終了            ==');
        $this->error('=====================================');
        $this->renderBoard($turn->getBoard());

        if ($turn->finishedLastTurn()) {
            $whitePoint = $turn->getBoard()->getPoint(Color::white());
            $blackPoint = $turn->getBoard()->getPoint(Color::black());
            $this->info( "◯：$whitePoint 対 ●：$blackPoint");
            if ($whitePoint === $blackPoint) {
                $result = '引き分け';
            } elseif ($whitePoint > $blackPoint){
                $result = '◯の勝ち';
            } else{
                $result = '●の勝ち';
            }
            $this->error('=====================================');
            $this->error('==            '. $result .'              ==');
            $this->error('=====================================');

        } elseif (!$turn->isContinuable()) {
            echo 'スキップが2回続いたためNo Gameで終了';
        } else {
            echo '不明なエラー発生により終了';
        }
        return 0;
    }

    private function renderBoard(Board $board)
    {
        $view = [];
        foreach ($board->toArray() as $rowNum => $row){
            $view[$rowNum][] = $rowNum + 1;
            foreach ($row as $value) {
                $view[$rowNum][] = match ($value) {
                    Color::white()->toCode() => '◯',
                    Color::black()->toCode() => '●',
                    default => ' ',
                };
            }
        }

        $this->table(['', 1,2,3,4,5,6,7,8], $view);
    }
}
