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
            <h2>Introduce tus datos</h2>
            <form>
                <p>Nombre de usuario: </p>
                <input type="text">
                
                <p>Correo electrónico: </p>
                <input type="email">

                <p>Contraseña: </p>
                <input type="password">

                <p>Repite la contraseña: </p>
                <input type="password">

                <br>
                <br>
                
                <input type="submit" value="Registrar">
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

        function verificado($nombre){
            $con=new mysqli("localhost","root","","honorAndGlory");
            if($con->connect_errno){
                echo "Fallo la conexion";
            }else{
                $consulta=$con->prepare(
                    "select correo from honorAndGlory.usuarios where nombre=?"
                );
                if($consulta!=null){
                    $consulta->bind_param("s",$nombre);
                    $consulta->execute();
                    $consulta->store_result();
                    $consulta->bind_result($nombre2);
                    if($nombre2!=$nombre){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
        }

        function verificadoPwd($pwd,$pwdR){
            if($pwd==$pwdR){
                return true;
            }else{
                return false;
            }
        }

        function verificadorDatos($email,$nombre,$pwd,$pwdR){
            if(!empty(filtrado($email) and !empty(filtrado($nombre) and !empty(filtrado($pwd) ){
                $nombre=filtrado($_POST['nombre']);
                $pwd=filtrado($_POST['pwd']);
                $pwdR=filtrado($_POST['pwdR']);
                if(verificado($nombre) and verificadoPwd($pwd,$pwdR)){
                    session_start();
                    $con=new mysqli("localhost","root","","honorAndGlory");
                    if($con->connect_errno){
                        echo "Fallo la conexion";
                    }
                    else{
                        $consulta=$con->prepare(
                            "INSERT INTO honorAndGlory.usuarios (nombre,pwd) VALUES ($nombre,$pwd)"
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
                        }
                    }
                }else{
                    //Datos de inicio de sesion erroneos
                }
            }else{
                //Datos de inicio vacios uno o mas
            }
        }
        function registrar(){
            
        }
        if(isset($_POST['registrar'])){
            
        }
    ?>
</body>
</html>
