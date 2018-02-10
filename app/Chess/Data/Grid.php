<?php

namespace App\Chess\Data;

use Illuminate\Support\Collection;


/**
 * @property int gridSize
 * @property Collection|Column[] columns
 */
class Grid extends AbstractDataObject
{

    /**
     * Collection containing fields from all columns by reference
     *
     * @var Collection|Field[]
     */
    protected $fields;

    /**
     * @return Collection|Field[]
     */
    public function getFields()
    {
        if (null !== $this->fields) {
            return $this->fields;
        }

        $this->fields = new Collection();

        foreach (array_pluck($this->columns, 'fields') as $fields) {
            $this->fields = $this->fields->merge($fields);
        }

        return $this->fields;
    }

}
