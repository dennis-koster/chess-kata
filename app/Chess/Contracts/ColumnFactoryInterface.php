<?php

namespace App\Chess\Contracts;

use App\Chess\Data\Column;

interface ColumnFactoryInterface
{
    /**
     * @param int $rowSize
     * @param int $index
     * @return Column
     */
    public function make(int $rowSize, $index = 0);
}
