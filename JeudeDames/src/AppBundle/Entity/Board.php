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
    private $board;
    private $coordBoard = array();
    private $player;

    public function board()
    {

    }

    public function initTab2D()
    {
        $tab = array();
        for ($x = 0; $x < 10; $x++) {
            $row = array();
            for ($y = 0; $y < 10; $y++) {
                $row[$y] = null;
            }
            $tab[$x] = $row;
        }
        return $tab;
    }

    public function initTab3D()
    {
        $line = array();
        for ($x = 0; $x < 10; $x++) {
            $row = array();
            for ($y = 0; $y < 10; $y++) {
                $z = array();
                for ($i = 0; $i < 10; $i++) {
                    $z[$i] = null;
                }
                $row[$y] = $z;
            }
            $line[$x] = $row;
        }
        return $line;
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
                if (($y % 2 != 0) && ($this->getCase($x,$y) == Type::Empty)) {
                    $this->board[$x][$y] = Type::WhitePawn;
                }
            }
        }

        //Je met un pion blanc, une case sur deux, dont lignes commençant par une case noire
        for ($x = 7; $x < 10; $x = $x + 2) {
            for ($y = 0; $y < 9; $y++) {
                if (($y % 2 == 0) && ($this->getCase($x,$y) == Type::Empty)) {
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
                if (($y % 2 != 0) && ($this->getCase($x,$y) == Type::Empty)) {
                    $this->board[$x][$y] = Type::BlackPawn;
                }
            }
        }

        //Je met un pion noir, une case sur deux, dont lignes commençant par une case noire
        for ($x = 1; $x < 4; $x = $x + 2) {
            for ($y = 0; $y < 9; $y++) {
                if (($y % 2 == 0) && ($this->getCase($x,$y) == Type::Empty)) {
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

    public function beLady($x, $y)
    {
        if (($this->getCase($x,$y) == Type::BlackPawn) && $x == 9) {
            $this->board[$x][$y] = Type::WhiteLady;
            return true;
        } elseif (($this->getCase($x,$y) == Type::WhitePawn) && $x == 0) {
            $this->board[$x][$y] = Type::BlackLady;
            return true;
        }
        return 1;
    }

    public function movePawns($xInit, $yInit, $x, $y)
    {
        if (($this->getCase($x,$y) == Type::Empty)
            && ($this->canEat($x, $y) == false)) {
            if ($this->board[$xInit][$yInit] == Type::WhitePawn
                && $xInit > $x
                && $this->player == Type::whitePlayer) {
                if ($x == 0) {
                    $this->board[$x][$y] = Type::WhiteLady;

                } else {
                    $this->board[$x][$y] = $this->board[$xInit][$yInit];
                }
                $this->free($xInit, $yInit);
                return true;

            } else if ($this->board[$xInit][$yInit] == Type::BlackPawn
                && $xInit < $x
                && $this->player == Type::blackPlayer) {

                if ($x == 9) {
                    $this->board[$x][$y] = Type::BlackLady;
                } else {
                    $this->board[$x][$y] = $this->board[$xInit][$yInit];
                }
                $this->free($xInit, $yInit);
                return true;
            }

        }
        return 2;
    }

    public function isEdible($x, $y, $case)
    {
        switch ($case) {
            case "hl" :
                if ($this->getCase($x,$y) == Type::WhitePawn
                    && $this->getCase($x-1,$y-1) == Type::BlackPawn
                    && $this->getCase($x-2,$y-2) == Type::Empty) {
                    return true;
                } elseif ($this->getCase($x,$y) == Type::BlackPawn
                    && $this->getCase($x-1,$y-1) == Type::WhitePawn
                    && $this->getCase($x-2,$y-2) == Type::Empty) {
                    return true;
                }
                break;
            case "hr" :
                if ($this->getCase($x,$y) == Type::WhitePawn
                    && $this->getCase($x-1,$y+1) == Type::BlackPawn
                    && $this->getCase($x-2,$y+2) == Type::Empty) {
                    return true;
                } elseif ($this->getCase($x,$y) == Type::BlackPawn
                    && $this->getCase($x-1,$y+1) == Type::WhitePawn
                    && $this->getCase($x-2,$y+2) == Type::Empty) {
                    return true;
                }
                break;
            case"ll":
                if ($this->getCase($x,$y) == Type::WhitePawn
                    && $this->getCase($x+1,$y-1) == Type::BlackPawn
                    && $this->getCase($x+2,$y-2) == Type::Empty) {
                    return true;
                } elseif ($this->getCase($x,$y) == Type::BlackPawn
                    && $this->getCase($x+1,$y-1) == Type::WhitePawn
                    && $this->getCase($x+2,$y-2) == Type::Empty) {
                    return true;
                }
                break;
            case "lr":
                if ($this->getCase($x,$y) == Type::WhitePawn
                    && $this->getCase($x+1,$y+1) == Type::BlackPawn
                    && $this->getCase($x+2,$y+2) == Type::Empty) {
                    return true;
                } elseif ($this->getCase($x,$y) == Type::BlackPawn
                    && $this->getCase($x+1,$y+1) == Type::WhitePawn
                    && $this->getCase($x+2,$y+2) == Type::Empty) {
                    return true;
                }
                break;
            default:
                return false;
                break;
        }
        return false;
    }

    public function canEat($x, $y)
    {
        if ($this->isEdible($x, $y, "hl") == false
            && $this->isEdible($x, $y, "hr") == false
            && $this->isEdible($x, $y, "ll") == false
            && $this->isEdible($x, $y, "lr") == false) {
            return false;
        } else {
            return true;
        }
    }

    public function free($x, $y)
    {
        if ($this->getCase($x,$y) != Type::Empty || Type::Forbidden || null) {
            $this->board[$x][$y] = Type::Empty;
            return true;
        }
        return 3;
    }

    public function eat($xEater, $yEater, $xEat, $yEat)
    {
        //Je calcul mon mouvement a effectuer en cas de prise
        $xMouv = (-2) * ($xEater - $xEat);
        $yMouv = (-2) * ($yEater - $yEat);

        //je vérifie si je peux mangé
        if ($xMouv == 2 && $yMouv == -2) {
            if ($this->isEdible($xEater, $yEater, "ll") == true) {
                //si oui je mange
                $xFutur = $xEater + $xMouv;
                $yFutur = $yEater + $yMouv;

                $this->board[$xFutur][$yFutur] = $this->board[$xEater][$yEater];
                $this->free($xEater, $yEater);
                $this->free($xEat, $yEat);

                return true;
            }
        } elseif ($xMouv == 2 && $yMouv == 2) {
            if ($this->isEdible($xEater, $yEater, "lr") == true) {
                $xFutur = $xEater + $xMouv;
                $yFutur = $yEater + $yMouv;

                $this->board[$xFutur][$yFutur] = $this->board[$xEater][$yEater];
                $this->free($xEater, $yEater);
                $this->free($xEat, $yEat);

                return true;
            }
        } elseif ($xMouv == -2 && $yMouv == -2) {
            if ($this->isEdible($xEater, $yEater, "hl") == true) {
                $xFutur = $xEater + $xMouv;
                $yFutur = $yEater + $yMouv;

                $this->board[$xFutur][$yFutur] = $this->board[$xEater][$yEater];
                $this->free($xEater, $yEater);
                $this->free($xEat, $yEat);

                return true;
            }
        } elseif ($xMouv == -2 && $yMouv == 2) {
            if ($this->isEdible($xEater, $yEater, "hr") == true) {
                $xFutur = $xEater + $xMouv;
                $yFutur = $yEater + $yMouv;

                $this->board[$xFutur][$yFutur] = $this->board[$xEater][$yEater];
                $this->free($xEater, $yEater);
                $this->free($xEat, $yEat);

                return true;
            }
        }

        return false;
    }

    public function changePlayer(){
        if ($this->player == Type::blackPlayer){
            $this->player = Type::whitePlayer;
            return true;
        }elseif  ($this->player == Type::whitePlayer) {
            $this->player = Type::blackPlayer;
            return true;
        }
        return 4;
    }

    public function movement($xInit, $yInit, $xFutur, $yFutur)
    {
        $xMouv = $xFutur - $xInit;
        $yMouv = $yFutur - $yInit;
        if (($xMouv == -1 || $xMouv == 1) && ($yMouv == -1 || $yMouv == 1)) {
            if ($this->canEat($xInit, $yInit)==false){
                $resu =  $this->movePawns($xInit, $yInit, $xFutur, $yFutur);
                if ($resu != true){
                    return $this->error($resu);
                }
                $resu = $this->changePlayer();
                if ($resu != true){
                    return $this->error($resu);
                }
            }
        } elseif (($xMouv == -2 || $xMouv == 2) && ($yMouv == -2 || $yMouv == 2)) {
            $xEat = 1/2*($xFutur-$xInit)+$xInit;
            $yEat = 1/2*($yFutur-$yInit)+$yInit;
            $this->eat($xInit, $yInit, $xEat, $yEat);
            //si le joueur ne peut plus jouer, c'est au tour de l'autre joueur
            if ($this->canEat($xFutur, $yFutur)==false) {
                $this->changePlayer();
            }
        }
        return $this->board[$xFutur][$yFutur];
    }

    public function main($xInit, $yInit, $xFutur, $yFutur)
    {
        //je vérifie si le joueur a bien pris un de ses pions
        if ($this->player % 2 == $this->board[$xInit][$yInit] % 2) {
            if ($this->board[$xInit][$yInit] == Type::WhitePawn || Type::BlackPawn) {
                $resu = $this->movement($xInit, $yInit, $xFutur, $yFutur);
                return $resu;
            } else {

            }
        }
        return "KO";
    }

    public function error($i){
        switch ($i){
            case 1:
                break;
            case 2:
                return "error : movePawns() didn't work";
                break;
            case 3:
                return "error : free() didn't work";
                break;
            case 4:
                return "error : changePlayer() didn't work";
                break;
            default:
                break;
        }
    }

    public function getCase($x,$y){
        if($x<10 && $x>=0 && $y<10 && $y>=0){
            return $this->board[$x][$y];
        }else {
            return false;
        }
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
     * @return mixed
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param mixed $player
     */
    public function setPlayer($player)
    {
        $this->player = $player;
    }


    /**
     * @retrun array
     */
    public function getSerializable()
    {
        return serialize($this->board);
    }


    /*
    public function ableToMovePawns($x, $y)
    {
        $possibilities = $this->initTab2D();
        $count = 0;
        if ($this->isEdible($x, $y, "hl") == false
            || $this->isEdible($x, $y, "hr")== false
            || $this->isEdible($x, $y, "ll")== false
            || $this->isEdible($x, $y, "lr")== false)
        {
            if ($y < 9 && $y > 0) {
                //Cas classique
                $possibilities[$count][0] = $x - 1;
                $possibilities[$count][1] = $y - 1;
                $count++;

                $possibilities[$count][0] = $x - 1;
                $possibilities[$count][1] = $y + 1;
            } elseif ($y == 0) {
                //Cas sur le bord droit
                $possibilities[$count][0] = $x - 1;
                $possibilities[$count][1] = $y + 1;
            } elseif ($y == 9) {
                //Cas sur le bord gauche
                $possibilities[$count][0] = $x - 1;
                $possibilities[$count][1] = $y - 1;
            }
        } else {
            $result = $this->initTab3D();
            $way = $this->initTab2D();
            $this->findAllWayPawns($x, $y, $count, $result, $way, 0 );

        }
        return $possibilities;
    }


    public function findAllWayPawns($x,$y, $count, $result, $way, $countResult){

        if ($this->isEdible($x, $y, "hl") == true)
        {
            $possibilities[$count][0] = $x;
            $possibilities[$count][1] = $y;
            $possibilities[$count][2] = $count;
            $count++;
            $this->findAllWayPawns($x-1, $y-1, $count,$result, $way, $countResult);
        }
        if ($this->isEdible($x, $y, "hr") == true)
        {
            $possibilities[$count][0] = $x;
            $possibilities[$count][1] = $y;
            $possibilities[$count][2] = $count;
            $count++;
            $this->findAllWayPawns($x-1, $y-1, $count,$result, $way, $countResult);
        }
        if ($this->isEdible($x, $y, "ll") == true)
        {
            $possibilities[$count][0] = $x;
            $possibilities[$count][1] = $y;
            $possibilities[$count][2] = $count;
            $count++;
            $this->findAllWayPawns($x-1, $y-1, $count,$result, $way, $countResult);
        }
        if ($this->isEdible($x, $y, "lr") == true)
        {
            $possibilities[$count][0] = $x;
            $possibilities[$count][1] = $y;
            $possibilities[$count][2] = $count;
            $count++;
            $this->findAllWayPawns($x-1, $y-1, $count,$result, $way, $countResult);
        }
        $result[$countResult] = $possibilities;
    }

    public function findLongerWayPawns($result){
        $longerWay = $this->initTab3D();
        $size = 0;
        $count = 0;
        $way = 0;
        for ($i=0; $i<10 ; $i++) {
            //Je compte la longueur du chemin
            while ($result[$i][2][$way] != null){
                $count++;
            }
            //si la longueur du chemin est plus grande que la longueur max précédente, je change la longueur max
            if ($count > $size){
                $size = $count;
            }
            $count = 0;
        }
        for ($i =0 ; $i <10 ; $i++){
            for ($j= 0; $j< 10; $j++){
                $longerWay[$i][$j][$way] = $result[$way];
            }
        }
    }
    */
}