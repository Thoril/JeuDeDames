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
    public $coordBoard = array();

    public function board()
    {

    }

    public function initTab2D()
    {
        $tab = array();
        for ($x = 0; $x < 10; $x++) {
            $row = array();
            for ($y = 0; $y < 10; $y++) {
                $row[$y] = 0;
            }
            $tab[$x] = $row;
        }
        return $tab;
    }

    public function initBoard()
    {
        $object = new board();
        $this->board = $object->initTab2D();

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
            if ($this->board[$xInit][$yInit] == Type::WhitePawn) {

            } else if ($this->board[$x][$y] == Type::BlackPawn) {

            }
            $this->board[$x][$y] = $this->board[$xInit][$yInit];
            $this->board[$xInit][$yInit] = Type::Empty;
        }
    }

    public function isEdible($x, $y, $case){
        switch ($case){
            case "hl" :
                if($this->board[$x][$y] == Type::WhitePawn
                    && $this->board[$x-1][$y-1] == Type::BlackPawn
                    && $this->board[$x-2][$y-2] == Type::Empty){
                    return true;
                }elseif ($this->board[$x][$y] == Type::BlackPawn
                    && $this->board[$x-1][$y-1] == Type::WhitePawn
                    && $this->board[$x-2][$y-2] == Type::Empty){
                    return true;
                }
                break;
            case "hr" :
                if($this->board[$x][$y] == Type::WhitePawn
                    && $this->board[$x-1][$y+1] == Type::BlackPawn
                    && $this->board[$x-2][$y+2] == Type::Empty){
                    return true;
                }elseif ($this->board[$x][$y] == Type::BlackPawn
                    && $this->board[$x-1][$y+1] == Type::WhitePawn
                    && $this->board[$x-2][$y+2] == Type::Empty){
                    return true;
                }
                break;
            case"ll":
                if($this->board[$x][$y] == Type::WhitePawn
                    && $this->board[$x+1][$y-1] == Type::BlackPawn
                    && $this->board[$x+2][$y-2] == Type::Empty){
                    return true;
                }elseif ($this->board[$x][$y] == Type::BlackPawn
                    && $this->board[$x+1][$y-1] == Type::WhitePawn
                    && $this->board[$x+2][$y-2] == Type::Empty){
                    return true;
                }
                break;
            case "lr":
                if($this->board[$x][$y] == Type::WhitePawn
                    && $this->board[$x+1][$y+1] == Type::BlackPawn
                    && $this->board[$x+2][$y+2] == Type::Empty){
                    return true;
                }elseif ($this->board[$x][$y] == Type::BlackPawn
                    && $this->board[$x+1][$y+2] == Type::WhitePawn
                    && $this->board[$x+1][$y+2] == Type::Empty){
                    return true;
                }
                break;
            default:
                return false;
                break;
        }
        return false;
    }

    /**
     * @return array
     */
    public function ableToMovePawns($x, $y)
    {
        $object = new board();
        $possibilities = $object->initTab2D();
        $count = 0;
        if ($object->isEdible($x, $y, "hl") == true
            || $object->isEdible($x, $y, "hr")== true
            || $object->isEdible($x, $y, "ll")== true
            || $object->isEdible($x, $y, "lr")== true)
        {
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

    public function free($x, $y)
    {
        if ($this->board[$x][$y] != Type::Empty || Type::Forbidden) {
            $this->board[$x][$y] = Type::Empty;
        }
    }

    public function eat($xEater, $yEater, $xEat, $yEat){
        $xMouv = (-2)*($xEater - $xEat);
        $yMouv = (-2)*($yEater - $yEat);

        $xFutur = $xEater + $xMouv;
        $yFutur = $yEater + $yMouv;

        $this->movePawns($xEater, $yEater, $xFutur, $yFutur);
        $this->free($xEat, $yEat);

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


}