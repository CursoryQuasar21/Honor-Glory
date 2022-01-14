<?php
    use Guerrero; 
    class Heroe implements Guerrero{

        private $vida;
        private $ataque;
        private $defensa;
        private $critico;
        private $guardia;

        public function __construct($vida,$ataque,$defensa,$critico,$guardia){
            $this->vida=$vida;
            $this->ataque=$ataque;
            $this->defensa=$defensa;
            $this->critico=$critico;
            $this->guardia=$guardia;
        }

        public function getVida(){
            return $this->vida;
        }
        public function setVida($vida){
            $this->vida=$vida;
        }
        public function getAtaque(){
            return $this->ataque;
        }
        public function setAtaque($ataque){
            $this->ataque=$ataque;
        }
        public function getDefensa(){
            return $this->defensa;
        }
        public function setDefensa($defensa){
            $this->defensa=$defensa;
        }
        public function getCritico(){
            return $this->critico;
        }
        public function setCritico($critico){
            $this->critico=$critico;
        }
        public function getGuardia(){
            return $this->guardia;
        }
        public function setGuardia($guardia){
            $this->guardia=$guardia;
        }
        
        public function atacar(){}
        public function defender(){}
        public function concentrar(){}
    }
?>