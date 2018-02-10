<?php

namespace App\Chess\Factories;

use App\Chess\Contracts\FieldFactoryInterface;
use App\Chess\Data\Field;
use Illuminate\Support\Collection;

class FieldFactory implements FieldFactoryInterface
{

    /**
     * @param string $columnIdentifier
     * @param int    $amount
     * @return Collection|Field[]
     */
    public function make(string $columnIdentifier, int $amount = 1)
    {
        $fields = new Collection();

        for ($i = 1; $i <= $amount; $i++) {
            $fields->push(
                $this->makeOne($columnIdentifier, $i)
            );
        }

        return $fields;
    }

    /**
     * @param string $columnIdentifier
     * @param int    $fieldNumber
     * @return Field
     */
    public function makeOne(string $columnIdentifier, int $fieldNumber = 1)
    {
        $fieldName = $this->generateFieldName($columnIdentifier, $fieldNumber);

        return new Field([
            'identifier'       => $fieldName,
            'columnIdentifier' => $columnIdentifier,
            'rowNumber'        => $fieldNumber,
            'available'        => true,
            'piecePlaced'      => false,
        ]);
    }

    /**
     * @param string $columnIdentifier
     * @param int    $fieldNumber
     * @return string
     */
    protected function generateFieldName(string $columnIdentifier, int $fieldNumber)
    {
        return $columnIdentifier . $fieldNumber;
    }

}
