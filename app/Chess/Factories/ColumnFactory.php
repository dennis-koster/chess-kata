<?php

namespace App\Chess\Factories;

use App\Chess\Contracts\ColumnFactoryInterface;
use App\Chess\Contracts\FieldFactoryInterface;
use App\Chess\Data\Column;

class ColumnFactory implements ColumnFactoryInterface
{
    public static $axisIdentifiers = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @var FieldFactoryInterface
     */
    protected     $fieldFactory;

    /**
     * @param FieldFactoryInterface|null $fieldFactory
     */
    public function __construct(FieldFactoryInterface $fieldFactory = null)
    {
        if (null === $fieldFactory) {
            $fieldFactory = app(FieldFactoryInterface::class);
        }

        $this->fieldFactory = $fieldFactory;
    }

    /**
     * @param int $rowSize
     * @param int $index
     * @return Column
     */
    public function make(int $rowSize, $index = 0)
    {
        $identifier = substr(static::$axisIdentifiers, $index, 1);

        $fields = $this->fieldFactory->make($identifier, $rowSize);

        return new Column([
            'identifier' => $identifier,
            'rowSize'    => $rowSize,
            'fields'     => $fields
        ]);
    }

}
