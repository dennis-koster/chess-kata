<?php

namespace App\Chess\Commands;

use App\Chess\ChessBoard;
use App\Chess\Presenters\ConsoleGridPresenter;
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
     * @var ConsoleGridPresenter
     */
    protected $gridPresenter;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->gridPresenter = new ConsoleGridPresenter();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $gridSize = (int) $this->argument('gridSize');
        $chessBoard = new ChessBoard($gridSize);

        $results = $chessBoard->calculateOutcomes();

        foreach ($results as $result) {
            list($headers, $data) = $this->gridPresenter->present($result);
            $this->table($headers, $data);
        }

        $this->info('Total amount of solutions: ' . $results->count());
    }
}
