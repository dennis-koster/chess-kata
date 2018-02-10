<?php

namespace Tests\Unit;

use App\Chess\ChessBoard;
use Tests\TestCase;

class ChessBoardTest extends TestCase
{
    /**
     * @param int $gridSize
     * @return ChessBoard
     */
    protected function getChessBoard(int $gridSize = 7)
    {
        return new ChessBoard(7);
    }

    public function testItGeneratesAGrid()
    {
        $chessBoard = $this->getChessBoard(7);
        $this->assertNotEmpty($chessBoard->grid);
        $this->assertEquals(7, $chessBoard->grid->columns->count());
    }


}
