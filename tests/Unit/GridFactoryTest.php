<?php

namespace Tests\Unit;

use App\Chess\Contracts\GridFactoryInterface;
use App\Chess\Data\Grid;
use Tests\TestCase;

class GridFactoryTest extends TestCase
{
    /**
     * @var GridFactoryInterface
     */
    protected $factory;

    /**
     * @param int $gridSize
     * @return Grid
     */
    protected function getGrid($gridSize = 7)
    {
        if (null === $this->factory) {
            $this->factory = app(GridFactoryInterface::class);
        }

        return $this->factory->make($gridSize);
    }

    public function testItGeneratesAGrid()
    {
        $grid = $this->getGrid(7);
        $this->assertEquals(7, $grid->columns->count());

        $grid = $this->getGrid(9);
        $this->assertEquals(9, $grid->columns->count());
    }
}
