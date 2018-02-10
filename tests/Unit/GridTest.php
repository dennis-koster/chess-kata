<?php

namespace Tests\Unit;

use App\Chess\Contracts\GridFactoryInterface;
use App\Chess\Data\Grid;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GridTest extends TestCase
{

    /**
     * @var GridFactoryInterface
     */
    protected $factory;

    /**
     * @param int $gridSize
     * @return Grid
     */
    protected function getGrid($gridSize = 7)
    {
        if (null === $this->factory) {
            $this->factory = app(GridFactoryInterface::class);
        }

        return $this->factory->make($gridSize);
    }

    public function testItCollectsFieldsFromAllColumns()
    {
        $grid = $this->getGrid(10);

        $fields = $grid->getFields();

        $this->assertEquals(100, $fields->count());
        $this->assertEquals('A1', $fields->first()->identifier);
        $this->assertEquals('J10', $fields->last()->identifier);
    }

    public function testFieldsAreCollectedByReference()
    {
        $grid = $this->getGrid(10);

        $fields = $grid->getFields();

        $original = $grid->columns->last()->fields->last();
        $referenced = $fields->last();

        $this->assertSame($original, $referenced);
        $original->available = false;
        $this->assertFalse($referenced->available);
    }
}
