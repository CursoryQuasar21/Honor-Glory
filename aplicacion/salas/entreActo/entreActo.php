<?php 
        session_start();
        if(isset($_SESSION['usuario'])){
            echo "Bienvenido ".$_SESSION['usuario'];
            if(isset($_POST['heroe1'])){
                $_SESSION['usuario']->setEleccion(1);
                header("Location: ../../partida/partida.php");
            }
            if(isset($_POST['heroe2'])){
                $_SESSION['usuario']->setEleccion(2);
                header("Location: ../../partida/partida.php");
            }
            if(isset($_POST['heroe3'])){
                $_SESSION['usuario']->setEleccion(3);
                header("Location: ../../partida/partida.php");
            }    
        }
        else
            header("Location: ../cuenta/singIn/singIn.php");
        
?>