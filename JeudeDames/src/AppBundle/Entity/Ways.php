<?php
/**
 * Created by PhpStorm.
 * User: auboi
 * Date: 29/05/2018
 * Time: 10:24
 */

namespace AppBundle\Entity;


use Board;
use Type;

class Ways
{
    private $coord = array(array());
    private $count;
    private $distance = array();
    private $board = array(array());
    private $color;

    public function ways(){

    }
    /**
     * @return array
     */
    public function findAllWayForBlackPawns($i, $j, $distance)
    {
        if ((($this->board[$i + 1][$j - 1] == Type::WhitePawn || Type::WhiteLady)
            || ($this->board[$i + 1][$j + 1] == Type::WhitePawn || Type::WhiteLady)
            || ($this->board[$i - 1][$j + 1] == Type::WhitePawn || Type::WhiteLady )
            || ($this->board[$i - 1][$j + 1] == Type::WhitePawn || Type::WhiteLady))

        )
        {
            if ($this->board[$i - 1][$j - 1] != Type::WhitePawn) {
                $this->findAllWayForBlackPawns($i - 2, $j - 2, $distance + 1);
            }
            if ($this->board[$i - 1][$j + 1] != Type::WhitePawn) {
                $this->findAllWayForBlackPawns($i - 2, $j + 2, $distance + 1);
            }
            if ($this->board[$i + 1][$j - 1] != Type::WhitePawn) {
                $this->findAllWayForBlackPawns($i + 2, $j - 2, $distance + 1);
            }
            if ($this->board[$i + 1][$j + 1] != Type::WhitePawn) {
                $this->findAllWayForBlackPawns($i + 2, $j + 2, $distance + 1);
            }
        } else {

            $this->coord[$this->count][0] = $i;
            $this->coord[$this->count][1] = $j;
            $this->distance[$this->count] = $distance;
            $this->count++;

        }
    }

    /**
     * @return array
     */
    public function getCoord(): array
    {
        return $this->coord;
    }

    /**
     * @param array $coord
     */
    public function setCoord(array $coord)
    {
        $this->coord = $coord;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param mixed $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param mixed $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * @return array
     */
    public function getBoard(): array
    {
        return $this->board;
    }

    /**
     * @param array $board
     */
    public function setBoard(array $board)
    {
        $this->board = $board;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }




}