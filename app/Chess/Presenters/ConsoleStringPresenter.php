<?php

namespace App\Chess\Presenters;

use App\Chess\Data\Grid;

class ConsoleStringPresenter
{
    /**
     * @param Grid $grid
     * @return string
     */
    public function present(Grid $grid)
    {
        $fields = $grid->getFields();
        $placements = $fields->where('piecePlaced', true)->all();

        return json_encode(array_pluck($placements, 'identifier'));
    }

}
