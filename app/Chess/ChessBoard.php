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
     * @param string|null $startingPoint
     * @return \Illuminate\Support\Collection
     */
    public function calculateOutcomes(string $startingPoint = null)
    {
        $outcomeCalculator = new OutcomeCalculator($this->gridSize);

        if (null === $startingPoint) {
            $placedPoints = [];
        } else {
            $placedPoints = [$startingPoint];
        }

        return $outcomeCalculator->calculate($placedPoints);
    }
}
