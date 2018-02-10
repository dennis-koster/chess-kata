<?php

namespace App\Chess\Data;

/**
 * @property string  identifier
 * @property string  columnIdentifier
 * @property int     rowNumber
 * @property boolean available
 * @property boolean piecePlaced
 */
class Field extends AbstractDataObject
{

    /**
     * Mark field as unavailable
     *
     * @return $this
     */
    public function invalidate()
    {
        $this->available = false;

        return $this;
    }

    /**
     * Mark field as having a piece placed
     *
     * @return $this
     */
    public function placePiece()
    {
        $this->available = false;
        $this->piecePlaced = true;

        return $this;
    }

}
