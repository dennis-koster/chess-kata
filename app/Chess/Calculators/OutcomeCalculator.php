<?php

namespace App\Chess\Calculators;

use App\Chess\Contracts\GridFactoryInterface;
use App\Chess\Data\Column;
use App\Chess\Data\Field;
use App\Chess\Data\Grid;
use App\Chess\Exceptions\FieldDoesNotExistException;
use App\Chess\Traits\ParsesFieldIdentifier;
use Illuminate\Support\Collection;

class OutcomeCalculator
{
    use ParsesFieldIdentifier;

    /**
     * @var Collection
     */
    protected $outcomes;

    /**
     * @var GridFactoryInterface
     */
    protected $gridFactory;

    /**
     * @var int
     */
    protected $gridSize;

    /**
     * @param int                       $gridSize
     * @param GridFactoryInterface|null $gridFactory
     */
    public function __construct($gridSize = 7, GridFactoryInterface $gridFactory = null)
    {
        $this->outcomes = new Collection();
        $this->gridSize = $gridSize;

        if (null == $gridFactory) {
            $gridFactory = app(GridFactoryInterface::class);
        }
        $this->gridFactory = $gridFactory;
    }

    /**
     * @param array $placedPositions
     * @return Collection|Grid[]
     */
    public function calculate($placedPositions = [])
    {
        $grid = $this->gridFactory->make($this->gridSize);
        try {
            $this->processPositions($grid, $placedPositions);
        } catch (FieldDoesNotExistException $e) {
            // Continue gracefully
            return;
        }

        // If there are no more pieces to be placed, stop execution
        if (count($placedPositions) === $this->gridSize) {
            $this->outcomes->push($grid);
            return;
        }

        $nextSteps = $this->getNextSteps($grid, count($placedPositions));
        // Spawn a new calculation for every possible next step
        foreach ($nextSteps as $nextStep) {
            $positionsToTry = $placedPositions;
            $positionsToTry[] = $nextStep->identifier;
            $this->calculate($positionsToTry);
        }

        return $this->outcomes;
    }

    /**
     * @param Grid $grid
     * @param int  $columnIndex
     * @return Collection|Field[]
     */
    protected function getNextSteps(Grid $grid, int $columnIndex = 1)
    {
        /** @var Column $column */
        $column = $grid->columns->get($columnIndex);
        if ( ! $column) {
            return null;
        }

        $fields = $column->fields;

        return $fields->where('available', true)->all();
    }

    /**
     * Marks field states based on given positions
     *
     * @param Grid  $grid
     * @param array $placedPositions
     * @return Grid
     * @throws FieldDoesNotExistException
     */
    protected function processPositions(Grid $grid, array $placedPositions = [])
    {
        foreach ($placedPositions as $position) {
            $this->processPosition($grid, $position);
        }

        return $grid;
    }

    /**
     * @param Grid   $grid
     * @param string $position
     * @throws FieldDoesNotExistException
     */
    protected function processPosition(Grid $grid, string $position)
    {
        $fields   = $grid->getFields();
        $positionData = $this->parseFieldIdentifier($position);

        $this   ->markPlaced($fields, $position)
                ->markHorizontal($fields, $positionData)
                ->markVertical($fields, $positionData)
                ->markDiagonally($grid, $positionData);
    }

    /**
     * @param Collection|Field[] $fields
     * @param string             $position
     * @return OutcomeCalculator
     * @throws FieldDoesNotExistException
     */
    protected function markPlaced(Collection $fields, string $position)
    {
        /** @var Field|null $fieldToMark */
        $fieldToMark = $fields->where('identifier', $position)->first();

        if (null === $fieldToMark) {
            throw new FieldDoesNotExistException("Field with identifier `{$position}` does not exist");
        }

        $fieldToMark->placePiece();

        return $this;
    }

    /**
     * @param Collection|Field[] $fields
     * @param array              $positionData
     * @return OutcomeCalculator
     */
    protected function markHorizontal(Collection $fields, array $positionData)
    {
        /** @var Collection|Field[] $horizontalFields */
        $horizontalFields = $fields->where('rowNumber', $positionData['rowNumber']);
        foreach ($horizontalFields as $field) {
            $field->invalidate();
        }

        return $this;
    }

    /**
     * @param Collection|Field[] $fields
     * @param array              $positionData
     * @return OutcomeCalculator
     */
    protected function markVertical(Collection $fields, array $positionData)
    {
        /** @var Collection|Field[] $verticalFields */
        $verticalFields = $fields->where('columnIdentifier', $positionData['columnIdentifier']);
        foreach ($verticalFields as $field) {
            $field->invalidate();
        }

        return $this;
    }

    /**
     * @param Grid  $grid
     * @param array $positionData
     * @return OutcomeCalculator
     */
    protected function markDiagonally(Grid $grid, array $positionData)
    {
        $columns = $grid->columns;

        $currentColumn = $columns->where('identifier', $positionData['columnIdentifier'])->first();
        $currentIndex = $columns->search($currentColumn);

        $upwards = $positionData['rowNumber'] - 1;
        $downWards = $positionData['rowNumber'] + 1;

        for ($i = $currentIndex+1; $i < $columns->count(); $i++) {

            /** @var Column $column */
            $column = $columns->get($i);

            $fields = $column->fields;

            /** @var Field|null $upField */
            $upField = $fields->where('rowNumber', $upwards)->first();

            if ($upField) {
                $upField->invalidate();
                $upwards--;
            }

            /** @var Field|null $downField */
            $downField = $fields->where('rowNumber', $downWards)->first();

            if ($downField) {
                $downField->invalidate();
                $downWards++;
            }
        }

        return $this;
    }

}
