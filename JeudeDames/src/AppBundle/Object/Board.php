<?php
/**
 * Created by PhpStorm.
 * User: auboi
 * Date: 15/05/2018
 * Time: 16:58
 */

class Board
{
    public $Board = array(array()) ;

    public function board(){

    }

    public function initBoard(){
        //Je met une case sur deux dont lignes commençant par une case blanche
        for($i = 0; $i<9 ; $i = $i+ 2){
            for ($j = 0; $j < 10 ; $j++ ) {
                if($j % 2 != 0){
                    $this->Board[$i][$j] = Type::Upmty;
                }else{
                    $this->Board[$i][$j] = Type::Forbidden;
                }
            }
        }
        
        //Je met une case sur deux dont lignes commençant par une case noire
        for($i = 1; $i<10 ; $i = $i+ 2){
            for ($j = 0; $j < 10 ; $j = $j++ ) {
                if($j % 2 != 0){
                    $this->Board[$i][$j] = Type::Forbidden;
                }else{
                    $this->Board[$i][$j] = Type::Upmty;
                }

            }
        }

    }

    public function initWhite(){
        //Je met un pion blanc, une case sur deux, dont lignes commençant par une case blanche
        for($i = 6; $i<9 ; $i = $i+ 2){
            for ($j = 0; $j < 10 ; $j++ ) {
                if(($j % 2 != 0)&&($this->Board[$i][$j] == Type::Upmty)) {
                    $this->Board[$i][$j] = Type::WhitePawn;
                }
            }
        }

        //Je met un pion blanc, une case sur deux, dont lignes commençant par une case noire
        for($i = 7; $i<10 ; $i = $i+ 2){
            for ($j = 0; $j < 10 ; $j++ ) {
                if(($j % 2 == 0)&&($this->Board[$i][$j] == Type::Upmty)){
                    $this->Board[$i][$j] = Type::WhitePawn;
                }
            }
        }
    }

    public function initBlack(){
        //Je met un pion noir, une case sur deux, dont lignes commençant par une case blanche
        for($i = 0; $i<3 ; $i = $i+ 2){
            for ($j = 1; $j < 10 ; $j++ ) {
                if(($j % 2 != 0)&&($this->Board[$i][$j] == Type::Upmty)) {
                    $this->Board[$i][$j] = Type::BlackPawn;
                }
            }
        }

        //Je met un pion noir, une case sur deux, dont lignes commençant par une case noire
        for($i = 7; $i<4 ; $i = $i+ 2){
            for ($j = 0; $j < 10 ; $j++ ) {
                if(($j % 2 == 0)&&($this->Board[$i][$j] == Type::Upmty)){
                    $this->Board[$i][$j] = Type::BlackPawn;
                }
            }
        }
    }

    public function initGame(){
        $this->initBoard();
        $this->initWhite();
        $this->initBlack();
    }

    /**
     * @return array
     */
    public function getBoard()
    {
        return $this->Board;
    }

    /**
     * @param array $Board
     */
    public function setBoard($Board)
    {
        $this->Board = $Board;
    }


}