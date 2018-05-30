<?php
/**
 * Created by PhpStorm.
 * User: auboi
 * Date: 29/05/2018
 * Time: 11:19
 */

namespace AppBundle\Entity;


use Type;

class Pawns
{
    private $type;
    private $color;

    public function pawns($type, $color){
        $this->color = $color;
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
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