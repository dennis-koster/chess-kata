<?php

namespace App\Chess\Factories;

use App\Chess\Contracts\ColumnFactoryInterface;
use App\Chess\Contracts\GridFactoryInterface;
use App\Chess\Data\Grid;
use Illuminate\Support\Collection;

class GridFactory implements GridFactoryInterface
{
    /**
     * @var ColumnFactoryInterface
     */
    protected $columnFactory;

    /**
     * @param ColumnFactoryInterface $columnFactory
     */
    public function __construct(ColumnFactoryInterface $columnFactory = null)
    {
        if (null === $columnFactory) {
            $columnFactory = app(ColumnFactoryInterface::class);
        }

        $this->columnFactory = $columnFactory;
    }

    /**
     * @param int $gridSize
     * @return Grid
     */
    public function make(int $gridSize)
    {
        $columns = new Collection();

        for ($i = 0; $i < $gridSize; $i++) {
            $columns->push(
                $this->columnFactory->make($gridSize, $i)
            );
        }

        return new Grid([
            'gridSize' => $gridSize,
            'columns'  => $columns,
        ]);
    }

}
