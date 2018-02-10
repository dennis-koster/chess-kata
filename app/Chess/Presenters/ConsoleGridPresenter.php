<?php

namespace App\Chess\Presenters;

use App\Chess\Data\Field;
use App\Chess\Data\Grid;
use Illuminate\Support\Collection;

class ConsoleGridPresenter
{

    /**
     * @param Grid $grid
     * @return array
     */
    public function present(Grid $grid)
    {
        $headers = array_merge([''], array_pluck($grid->columns, 'identifier'));
        $data = [];
        $rows = $grid->getFields()->groupBy('rowNumber');

        /**
         * @var int $rowNumber
         * @var Collection|Field[] $fields
         */
        foreach ($rows as $rowNumber => $fields) {

            $row = [$rowNumber];

            foreach ($fields as $field) {
                $row[] = $field->piecePlaced ? 'X' : ($field->available ? '' : '.');
            }

            $data[] = $row;
        }

        return [$headers, $data];
    }

}
