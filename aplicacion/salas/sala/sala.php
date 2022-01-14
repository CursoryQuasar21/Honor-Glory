<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        use Partida;
        session_start();
        if(isset($_SESSION['usuario'])){
            if(isset($_SESSION[$_POST['nombreSala']])){
                $partida=$_SESSION[$_POST['nombreSala']];
            }else{
                $partida=new Partida(array($_SESSION['usuario'],new Ia()),3);
            }
            if($partida->getRondas()>0){
                if($partida->getJugadores()[0]->getHeroes()[$partida->getJugadores()[0]->getEleccion()]->getVida()>0
                        || $partida->getJugadores()[1]->getHeroes()[$partida->getJugadores()[1]->getEleccion()]->getVida()>0){
                    //Jugador 1
                    if(isset($_POST['combatir']) ){//Añadir comprobacion de radiobuton para la eleccion de la accion
                        $partida->pelea($_POST['accion']);
                    }
                    //Se realiza el combate
                }else{
                    $partida->setRondas($partida->getRondas()-1);
                }
                $_SESSION[$_POST['nombreSala']]=$partida;
                header("Location: ../../sala.php");
            }else{
                //Fin de partida
            }
        }
        else
            header("Location: ../../cuenta/singIn/singIn.php");
    ?>
</body>
</html>