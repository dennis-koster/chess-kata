<?php

namespace App\Chess;

use App\Chess\Calculators\OutcomeCalculator;
use App\Chess\Contracts\GridFactoryInterface;
use App\Chess\Data\Grid;

class ChessBoard
{
    /**
     * @var int
     */
    protected $gridSize;

    /**
     * @var GridFactoryInterface|null
     */
    protected $gridFactory;

    /**
     * @param int                       $gridSize
     * @param Grid|null                 $grid
     * @param GridFactoryInterface|null $gridFactory
     */
    public function __construct(int $gridSize, Grid $grid = null, GridFactoryInterface $gridFactory = null)
    {
        $this->gridSize = $gridSize;

        if (null === $gridFactory) {
            $gridFactory = app(GridFactoryInterface::class);
        }

        $this->gridFactory = $gridFactory;
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws Exceptions\FieldDoesNotExistException
     */
    public function calculateOutcomes()
    {
        $outcomeCalculator = new OutcomeCalculator($this->gridSize);

        return $outcomeCalculator->calculate([]);
    }
}
