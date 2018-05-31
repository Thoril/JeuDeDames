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

        //test pour un pion blanc
        $board->setPlayer(Type::whitePlayer);
        $board->movePawns(6,3,5,4);
        $my_board = $board->getBoard();
        $this->assertEquals(Type::WhitePawn, $my_board[5][4]);
        $this->assertEquals(Type::Empty, $my_board[6][3]);

        //test pour un pion noir
        $board->setPlayer(Type::blackPlayer);
        $board->movePawns(3,4,4,5);
        $my_board = $board->getBoard();
        $this->assertEquals(Type::BlackPawn, $my_board[4][5]);
        $this->assertEquals(Type::Empty, $my_board[3][4]);
    }

    public function testEat(){
        $board = new Board();
        $board->initGame();

        //test pour un joueur avec des pions noirs
        $board->setPlayer(Type::blackPlayer);
        $board->movePawns(3,4,4,5);

        $board->setPlayer(Type::whitePlayer);
        $board->movePawns(6,7,5,6);

        $board->setPlayer(Type::whitePlayer);
        $board->eat(5,6,4,5);
        $my_board = $board->getBoard();
        $this->assertEquals(Type::WhitePawn, $my_board[3][4]);
        $this->assertEquals(Type::Empty, $my_board[4][5]);
        $this->assertEquals(Type::Empty, $my_board[5][6]);
    }

    public function testMovement(){
        $board = new Board();
        $board->initGame();
        $board->setPlayer(Type::whitePlayer);

        //test déplacement pion blanc
        $board->movement(6,7,5,6);
        $my_board = $board->getBoard();
        $this->assertEquals(Type::WhitePawn, $my_board[5][6]);
        $this->assertEquals(Type::Empty, $my_board[6][7]);
        //test changement du joueur
        $this->assertEquals(Type::blackPlayer, $board->getPlayer());

        //test déplacement pion noir
        $board->movement(3,4,4,5);
        $my_board = $board->getBoard();
        $this->assertEquals(Type::BlackPawn, $my_board[4][5]);
        $this->assertEquals(Type::Empty, $my_board[3][4]);
        //test changement du joueur
        $this->assertEquals(Type::whitePlayer, $board->getPlayer());

        //test mange pion noir par pion blanc
        $board->movement(5,6,3,4);
        $my_board = $board->getBoard();
        $this->assertEquals(Type::WhitePawn, $my_board[3][4]);
        $this->assertEquals(Type::Empty, $my_board[5][6]);
        $this->assertEquals(Type::Empty, $my_board[4][5]);
        //test changement du joueur
        $this->assertEquals(Type::blackPlayer, $board->getPlayer());

    }

    public function testMain(){
        $board = new Board();
        $board->initGame();
        $board->setPlayer(Type::whitePlayer);

        //test déplacement pion blanc
        $board->main(6,7,5,6);
        $my_board = $board->getBoard();
        $this->assertEquals(Type::WhitePawn, $my_board[5][6]);
        $this->assertEquals(Type::Empty, $my_board[6][7]);
        //test changement du joueur
        $this->assertEquals(Type::blackPlayer, $board->getPlayer());

        //test déplacement pion noir
        $board->main(3,4,4,5);
        $my_board = $board->getBoard();
        $this->assertEquals(Type::BlackPawn, $my_board[4][5]);
        $this->assertEquals(Type::Empty, $my_board[3][4]);
        //test changement du joueur
        $this->assertEquals(Type::whitePlayer, $board->getPlayer());

        //test mange pion noir par pion blanc
        $board->main(5,6,3,4);
        $my_board = $board->getBoard();
        $this->assertEquals(Type::WhitePawn, $my_board[3][4]);
        $this->assertEquals(Type::Empty, $my_board[5][6]);
        $this->assertEquals(Type::Empty, $my_board[4][5]);
        //test changement du joueur
        $this->assertEquals(Type::blackPlayer, $board->getPlayer());

        //test mange pion blanc par pion noir
        $board->main(2,5,4,3);
        $my_board = $board->getBoard();
        $this->assertEquals(Type::BlackPawn, $my_board[4][3]);
        $this->assertEquals(Type::Empty, $my_board[3][4]);
        $this->assertEquals(Type::Empty, $my_board[2][5]);
        //test changement du joueur
        $this->assertEquals(Type::whitePlayer, $board->getPlayer());

    }
}