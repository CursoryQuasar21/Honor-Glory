<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="contenedor">
        <div class="registro">
            <h2>Iniciar sesión</h2>
            <form>
                <p>Correo electrónico: </p>
                <input type="email">

                <p>Contraseña: </p>
                <input type="password">

                <br>
                <br>

                <input type="submit" value="Entrar">
                <input type="reset" value="Borrar">
            </form>
        </div>
	</div>
    <?php

        //use Jugador;

        function filtrado($texto){
            $texto=trim($texto);
            $texto=htmlspecialchars($texto);
            $texto=stripslashes($texto);
            return $texto;
        }
        
        function verificado($pwd){
            $con=new mysqli("localhost","root","","honorAndGlory");
            if($con->connect_errno){
                echo "Fallo la conexion";
            }
            else{
                $consulta=$con->prepare(
                    "select pwd from honorAndGlory.usuarios where nombre=?"
                );
                if($consulta!=null){
                    $consulta->bind_param("s",$pwd);
                    $consulta->execute();
                    $consulta->store_result();
                    $consulta->bind_result($pwdBd);
                    if($pwdBd==$pwd){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
        }

        if(isset($_POST['inicioSesion'])){
            if(!empty(filtrado($_POST['nombre'])) and !empty(filtrado($_POST['pwd']))){
                $nombre=filtrado($_POST['nombre']);
                $pwd=filtrado($_POST['pwd']);
                if(verificado($pwd)){
                    session_start();
                    $con=new mysqli("localhost","root","","honorAndGlory");
                    if($con->connect_errno){
                        echo "Fallo la conexion";
                    }else{
                        $consulta=$con->prepare(
                            "select * from honorAndGlory.usuarios where nombre=?"
                        );
                        if($consulta!=null){
                            $consulta->bind_param("s",$nombre);
                            $consulta->execute();
                            $consulta->store_result();
                            $consulta->bind_result($nombre,$puntuacion);
                            while($consulta->fetch()){
                                $_SESSION['usuario']=new Jugador($nombre,$puntuacion,0);
                                header("Location: ../../../../../homepage/homepage.php");
                            }
                        }else{
                            //No se ha encontrado ningun usuario 
                        }
                    }
                }else{
                    //La conctraseña es erronea
                }
            }else{
                //Algun dato de inicio esta vacio
            }
        }
    ?>
</body>
</html>
