<?php

namespace App\Chess\Contracts;

use App\Chess\Data\Field;
use Illuminate\Support\Collection;

interface FieldFactoryInterface
{
    /**
     * @param string $columnIdentifier
     * @param int    $amount
     * @return Collection|Field[]
     */
    public function make(string $columnIdentifier, int $amount = 1);

    /**
     * @param string $columnIdentifier
     * @param int    $fieldNumber
     * @return Field
     */
    public function makeOne(string $columnIdentifier, int $fieldNumber = 1);

}
