<?php

    include_once "../personajes/vanguardia.php";
    include_once "../personajes/pesado.php";
    include_once "../personajes/asesino.php";

    class Jugador{
        private $nombre;
        private $puntuacion;
        private $heroes;
        private $eleccion;
        public function __construct($nombre,$puntuacion,$eleccion){
            $this->nombre=$nombre;
            $this->puntuacion=$puntuacion;
            $this->eleccion=$eleccion;
            $this->heroes=array(new Vanguardia(100,15,10,10.0,false),
                                new Asesino(75,20,10,15.0,false),
                                new Pesado(150,10,10,5.0,false));
        }

        public function getNombre(){
            return $this->nombre;
        }
        public function setNombre($nombre){
            $this->nombre=$nombre;
        }
        public function getPuntuacion(){
            return $this->puntuacion;
        }
        public function setPuntuacion($puntuacion){
            $this->puntuacion=$puntuacion;
        }
        public function getEleccion(){
            return $this->eleccion;
        }
        public function setEleccion($eleccion){
            $this->eleccion=$eleccion;
        }
        public function getHeroes(){
            return $this->heroes;
        }
        public function setHeroes($heroes){
            $this->heroes=$heroes;
        }
    }
?>