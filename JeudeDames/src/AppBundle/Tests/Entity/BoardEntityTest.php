<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Board;
use AppBundle\Entity\Type;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: auboi
 * Date: 29/05/2018
 * Time: 16:05
 */

class BoardEntityTest extends TestCase{
    public function testInitBoard(){
        $board = new Board();
        $board->initBoard();
        $my_board = $board->getBoard();
        $this->assertEquals(Type::Forbidden, $my_board[0][0]);
        $this->assertEquals(Type::Empty, $my_board[4][3]);
    }

    public function testInitWhite(){
        $board = new Board();
        $board->initBoard();
        $board->initWhite();
        $my_board = $board->getBoard();
        $this->assertEquals(Type::WhitePawn, $my_board[8][5]);
    }

    public function testInitBlack(){
        $board = new Board();
        $board->initBoard();
        $board->initBlack();
        $my_board = $board->getBoard();
        $this->assertEquals(Type::BlackPawn, $my_board[1][0]);
    }

    public function testInitGame(){
        $board = new Board();
        $board->initGame();
        $my_board = $board->getBoard();
        $this->assertEquals(Type::Forbidden, $my_board[0][0]);
        $this->assertEquals(Type::Empty, $my_board[4][3]);
        $this->assertEquals(Type::WhitePawn, $my_board[8][5]);
        $this->assertEquals(Type::BlackPawn, $my_board[1][0]);
    }

    public function testMovePawns(){
        $board = new Board();
        $board->initGame();
        $board->movePawns(6,3,5,4);
        $my_board = $board->getBoard();
        $this->assertEquals(Type::WhitePawn, $my_board[5][4]);
        $this->assertEquals(Type::Empty, $my_board[6][3]);
    }


}