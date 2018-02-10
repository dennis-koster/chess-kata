<?php

namespace App\Chess\Traits;

trait ParsesFieldIdentifier
{

    /**
     * @param string $position
     * @return array
     */
    protected function parseFieldIdentifier(string $position)
    {
        return [
            'columnIdentifier' => substr($position, 0, 1),
            'rowNumber'        => substr($position, 1),
        ];
    }

}
