<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameRepository")
 */
class Game
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="creator", type="integer", nullable=true)
     */
    private $creator;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="opponant", type="integer", nullable=true)
     */
    private $opponant;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="integer")
     */
    private $state;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="board", type="object", nullable=true)
     */
    private $board;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Game
     */
    public function setName($name)
    {
        $this->name = $name;
    }



    /**
     * Set creator
     *
     * @param integer $creator
     *
     * @return Game
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return int
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set opponant
     *
     * @param integer $opponant
     *
     * @return Game
     */
    public function setOpponant($opponant)
    {
        $this->opponant = $opponant;

        return $this;
    }

    /**
     * Get opponant
     *
     * @return int
     */
    public function getOpponant()
    {
        return $this->opponant;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Game
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set board
     *
     * @param \stdClass $board
     *
     * @return Game
     */
    public function setBoard($board)
    {
        $this->board = $board;

        return $this;
    }

    /**
     * Get board
     *
     * @return \stdClass
     */
    public function getBoard()
    {
        return $this->board;
    }
}

