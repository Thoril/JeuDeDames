<?php

namespace AppBundle\Entity;


use AppBundle\Entity\Pawns;

/**
 * Created by PhpStorm.
 * User: auboi
 * Date: 15/05/2018
 * Time: 16:58
 */

class Board
{
    public $board;
    public $coordBoard = array(array());

    public function board()
    {

    }

    public function initBoard()
    {
        for ($x = 0; $x < 10; $x++) {
            $row = array();
            for ($y = 0; $y < 10; $y++) {
                $row[$y] = 100262;
            }
            $this->board[$x] = $row;
        }

        //Je met une case sur deux dont lignes commençant par une case blanche
        for ($x = 0; $x < 9; $x = $x + 2) {
            for ($y = 0; $y < 10; $y++) {
                if ($y % 2 != 0) {
                    $this->board[$x][$y] = Type::Empty;
                } else {
                    $this->board[$x][$y] = Type::Forbidden;
                }
            }
        }

        //Je met une case sur deux dont lignes commençant par une case noire
        for ($x = 1; $x < 10; $x = $x + 2) {
            for ($y = 0; $y < 10; $y++) {
                if ($y % 2 != 0) {
                    $this->board[$x][$y] = Type::Forbidden;
                } else {
                    $this->board[$x][$y] = Type::Empty;
                }

            }
        }

    }

    public function initWhite()
    {
        //Je met un pion blanc, une case sur deux, dont lignes commençant par une case blanche
        for ($x = 6; $x < 9; $x = $x + 2) {
            for ($y = 0; $y < 10; $y++) {
                if (($y % 2 != 0) && ($this->board[$x][$y] == Type::Empty)) {
                    $this->board[$x][$y] = Type::WhitePawn;
                }
            }
        }

        //Je met un pion blanc, une case sur deux, dont lignes commençant par une case noire
        for ($x = 7; $x < 10; $x = $x + 2) {
            for ($y = 0; $y < 9; $y++) {
                if (($y % 2 == 0) && ($this->board[$x][$y] == Type::Empty)) {
                    $this->board[$x][$y] = Type::WhitePawn;
                }
            }
        }
    }

    public function initBlack()
    {
        //Je met un pion noir, une case sur deux, dont lignes commençant par une case blanche
        for ($x = 0; $x < 3; $x = $x + 2) {
            for ($y = 1; $y < 10; $y++) {
                if (($y % 2 != 0) && ($this->board[$x][$y] == Type::Empty)) {
                    $this->board[$x][$y] = Type::BlackPawn;
                }
            }
        }

        //Je met un pion noir, une case sur deux, dont lignes commençant par une case noire
        for ($x = 1; $x < 4; $x = $x + 2) {
            for ($y = 0; $y < 9; $y++) {
                if (($y % 2 == 0) && ($this->board[$x][$y] == Type::Empty)) {
                    $this->board[$x][$y] = Type::BlackPawn;
                }
            }
        }
    }

    public function initGame()
    {
        $this->initBoard();
        $this->initWhite();
        $this->initBlack();
    }

    public function beLady($x, $y){
        if (($this->board[$x][$y] == Type::BlackPawn) && $x == 9){
            $this->board[$x][$y] = Type::WhiteLady;
        }elseif(($this->board[$x][$y] == Type::WhitePawn) && $x == 0){
            $this->board[$x][$y] = Type::BlackLady;
        }
    }

    public function movePawns($xInit, $yInit, $x, $y)
    {
        if ($this->board[$x][$y] == Type::Empty) {
            if ($this->board[$x][$y] == Type::WhitePawn) {

            } else if ($this->board[$x][$y] == Type::BlackPawn) {

            }
            $this->board[$x][$y] = $this->board[$xInit][$yInit];
            $this->board[$xInit][$yInit] = Type::Empty;
        }
    }

    /**
     * @return array
     */
    public function ableToMoveWhitePawns($x, $y)
    {
        $possibilities = array(array());
        $count = 0;
        if (($this->board[$x + 1][$y - 1] != Type::BlackPawn) && ($this->board[$x + 1][$y + 1] != Type::BlackPawn) && ($this->board[$x - 1][$y + 1] != Type::BlackPawn) && ($this->board[$x - 1][$y + 1] != Type::BlackPawn)) {
            if ($y < 9 && $y > 0) {
                //Cas classique
                $possibilities[$count][0] = $x - 1;
                $possibilities[$count][1] = $y - 1;
                $count++;

                $possibilities[$count][0] = $x - 1;
                $possibilities[$count][1] = $y + 1;
                $count++;
            } elseif ($y == 0) {
                //Cas sur le bord droit
                $possibilities[$count][0] = $x - 1;
                $possibilities[$count][1] = $y + 1;
                $count++;
            } elseif ($y == 9) {
                //Cas sur le bord gauche
                $possibilities[$count][0] = $x - 1;
                $possibilities[$count][1] = $y - 1;
                $count++;
            }
        } else {
            $possibilities = $this->findAllWayPawns($x, $y);
        }
        return $possibilities;
    }

    /**
     * @return array
     */
    public function ableToMoveBlackPawns($x, $y)
    {
        $possibilities = array(array());
        $count = 0;
        if ((($this->board[$x + 1][$y - 1] != Type::WhitePawn) && ($this->board[$x + 2][$y - 2] != Type::Empty))
            && (($this->board[$x + 1][$y + 1] != Type::WhitePawn) && ($this->board[$x + 2][$y + 2] != Type::Empty))
            && (($this->board[$x - 1][$y + 1] != Type::WhitePawn) && ($this->board[$x - 2][$y + 2] != Type::Empty))
            && (($this->board[$x - 1][$y + 1] != Type::WhitePawn)&& ($this->board[$x - 2][$y + 2] != Type::Empty)))
        {
            if ($y < 9 && $y > 0) {
                //Cas classique
                $possibilities[$x][0] = $x + 1;
                $possibilities[$x][1] = $y - 1;
                $count++;

                $possibilities[$x][0] = $x + 1;
                $possibilities[$x][1] = $y + 1;
                $count++;
            } elseif ($y == 0) {
                //Cas sur le bord droit
                $possibilities[$x][0] = $x + 1;
                $possibilities[$x][1] = $y + 1;
                $count++;
            } elseif ($y == 9) {
                //Cas sur le bord gauche
                $possibilities[$x][0] = $x + 1;
                $possibilities[$x][1] = $y - 1;
                $count++;
            }
        } else {
            $possibilities = $this->findAllWayPawns($x, $y);
        }
        return $possibilities;
    }

    public function eat($x, $y)
    {
        if ($this->board[$x][$y] != Type::Empty || Type::Forbidden) {
            $this->board[$x][$y] = Type::Empty;
        }
    }

    public function isOpponant($x, $y, $color){
        //if($color == Type::)
    }

    /**
     * @return array
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * @param array $Board
     */
    public function setBoard($Board)
    {
        $this->board = $Board;
    }

    /**
     * @return array
     */
    public function getCoordBoard(): array
    {
        return $this->coordBoard;
    }

    /**
     * @param array $coordBoard
     */
    public function setCoordBoard(array $coordBoard)
    {
        $this->coordBoard = $coordBoard;
    }

    /**
     * @retrun array
     */
    public function getSerializable(){
        return serialize($this->board);
    }


}