<?php
    
    class Partida{
        private $id;
        private $jugadores;
        private $rondas;
        private $marcador;
        private $estado;

        public function __construct($jugadores,$rondas){
            $this->jugadores=$jugadores;
            $this->rondas=$rondas;
            $this->marcador=array(0,0);
            $this->estado=false;
        }

        public function getId(){
            return $this->id;
        }
        public function getJugadores(){
            return $this->jugadores;
        }
        public function getRondas(){
            return $this->rondas;
        }
        public function setRondas($rondas){
            return $this->rondas=$rondas;
        }
        public function getMarcador(){
            return $this->marcador;
        }
        public function setMarcador($marcador){
            return $this->marcador=$marcador;
        }

        public function peleaJB($accion){
            $accionesBot=array("atacar","defender","concentrar");
            $accionBot=$accionesBot[rand(0,2)];
            //Primero se validan los potenciadores
            $potenciadores=$this->potenciadores($accion,$this->jugadores[0]->getEleccion());
            $potenciadoresBot=$this->potenciadores($accionBot,$this->jugadores[1]->getEleccion());
            //Segundo se acativa la defensa si ha si lo ha elegido
            if($accionBot=="defender"){
                $potenciadoresBot[0]+=50;
            }
            //Tercero el Jugador1 lleva acabo su accion y se muestra el resultado
            if($accion!=null){
                if($accion=="atacar"){
                    $this->jugadores[1]->getHeroes()[$this->jugadores[1]->getEleccion()]->setVida(
                           ($this->jugadores[1]->getHeroes()[$this->jugadores[1]->getEleccion()]->getVida()+$potenciadoresBot[0])-
                            ($this->jugadores[0]->getHeroes()[$this->jugadores[0]->getEleccion()]->getAtaque()+$potenciadoresBot[1])
                        );
                }
                if($accion=="defender"){
                    $potenciadores[0]+=50;
                }
            }
            //Cuarto el Jugador2(Bot) lleva acabo su accion y se muestra el resultado
            if($accionBot=="atacar"){
                $this->jugadores[0]->getHeroes()[$this->jugadores[0]->getEleccion()]->setVida(
                       ($this->jugadores[0]->getHeroes()[$this->jugadores[0]->getEleccion()]->getVida()+$potenciadores[0])-
                        ($this->jugadores[1]->getHeroes()[$this->jugadores[1]->getEleccion()]->getAtaque()+$potenciadoresBot[1])
                    );
            }
        }

        public function potenciadores($accion,$personaje){
            $vida=0;
            $daño=0;
            if($accion=="concentrar"){
                switch($personaje){
                    case 0:
                        $daño+=50;
                        break;
                    case 1:
                        $vida+=15;
                        $daño+=65;
                        break;
                    case 2:
                        $vida+=85;
                        break;
                }
            }
            return array($vida,$daño);
        }

        public function iniciarPartida(){
            return $this->estado=true;
        }
        public function finalizarPartida(){
            return $this->estado=false;
        }
    }
?>