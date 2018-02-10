<?php

namespace App\Chess\Commands;

use App\Chess\ChessBoard;
use App\Chess\Presenters\ConsoleStringPresenter;
use App\Chess\Presenters\ConsoleTablePresenter;
use Illuminate\Console\Command;

class CalculateOutcomes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chess:calculate 
        {gridSize=7 : Size of the grid (default: 7)} 
        {startingPoint? : Identifier of field from which to start. For example: "A2" (optional}}
        {--prettyPrint : Whether or not the outcomes should be pretty printed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate outcomes of chessboard with given grid size';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $startTime = microtime(true);
        if ($this->option('prettyPrint')) {
            $presenter = new ConsoleTablePresenter();
        } else {
            $presenter = new ConsoleStringPresenter();
        }

        $gridSize = (int) $this->argument('gridSize');
        $chessBoard = new ChessBoard($gridSize);

        $results = $chessBoard->calculateOutcomes($this->argument('startingPoint'));
        $calculationTime = microtime(true) - $startTime;

        foreach ($results as $solution => $result) {
            $this->info('Solution ' . ($solution + 1));
            if ($presenter instanceof ConsoleTablePresenter) {
                list($headers, $data) = $presenter->present($result);
                $this->table($headers, $data);
                continue;
            }

            $this->info(
                $presenter->present($result)
            );
        }

        $this->info('Total amount of solutions: ' . $results->count());
        $this->info('Calculation took ' . $calculationTime . ' seconds');
    }
}
