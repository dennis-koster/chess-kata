<?php

namespace App\Chess\Contracts;

use App\Chess\Data\Grid;

interface GridFactoryInterface
{

    /**
     * @param int $gridSize
     * @return Grid
     */
    public function make(int $gridSize);

}
