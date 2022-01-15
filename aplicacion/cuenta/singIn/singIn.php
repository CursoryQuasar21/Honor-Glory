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
            <form name="formulario" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"> 
                <p>Nombre: </p>
                <input type="text" name="nombre">

                <p>Contraseña: </p>
                <input type="password" name="pwd">

                <br>
                <br>

                <button type="submit" name="submit">Sing In</button>
                <button type="reset" value="Reset">Reset</button>
            </form>
        </div>
	</div>
    <?php

        include_once "../../entidades/jugadores/jugador.php";

        function filtrado($texto){
            $texto=trim($texto);
            $texto=htmlspecialchars($texto);
            $texto=stripslashes($texto);
            return $texto;
        }
        
        function verificarNombre($nombre){
            $dsn="mysql:host=localhost;charset=utf8;dbname=honorandglory";
            $options=array(PDO::ATTR_PERSISTENT=>true);
            try{
                $db=new PDO($dsn,"root","",$options);
            }
            catch(PDOException $e){
                die("Error!: ". $e->getMessage()."<br>");
            }
            $query='select nombre from usuarios where nombre=?';
            $queryResultado=$db->prepare($query);
            $queryResultado->execute(array($nombre));
            while($match=$queryResultado->fetch(PDO::FETCH_ASSOC)){
                if($match['nombre']==$nombre){
                    return true;
                }
            }
            return false;
        }

        function verificarPwd($nombre,$pwd){
            $dsn="mysql:host=localhost;charset=utf8;dbname=honorandglory";
            $options=array(PDO::ATTR_PERSISTENT=>true);
            try{
                $db=new PDO($dsn,"root","",$options);
            }
            catch(PDOException $e){
                die("Error!: ". $e->getMessage()."<br>");
            }
            $query='select pwd from usuarios where nombre=?';
            $queryResultado=$db->prepare($query);
            $queryResultado->execute(array($nombre));
            while($match=$queryResultado->fetch(PDO::FETCH_ASSOC)){
                if($match['pwd']==$pwd){
                    return true;
                }
            }
            return false;
        }

        function verificarDatos($nombre,$pwd){
            if(!empty(filtrado($nombre)) and !empty(filtrado($pwd))){
                $nombre=filtrado($_POST['nombre']);
                $pwd=filtrado($_POST['pwd']);
                if(verificarNombre($nombre) and verificarPwd($nombre,$pwd)){
                    echo "hola2"; 
                    iniciarSesion($nombre);
                }else{
                    //Datos de inicio de sesion erroneos
                }
            }else{
                //Datos de inicio vacios uno o mas
            }
        }

        function iniciarSesion($nombre){
            $dsn="mysql:host=localhost;charset=utf8;dbname=honorandglory";
            $options=array(PDO::ATTR_PERSISTENT=>true);
            try{
                $db=new PDO($dsn,"root","",$options);
            }
            catch(PDOException $e){
                die("Error!: ". $e->getMessage()."<br>");
            }
            $query='select nombre,puntuacion,eleccion from usuarios where nombre=?';
            $queryResultado=$db->prepare($query);
            $queryResultado->execute(array($nombre));
            while($match=$queryResultado->fetch(PDO::FETCH_ASSOC)){
                $_SESSION['usuario']=new Jugador($match['nombre'],$match['puntuacion'],$match['eleccion']);
                header("Location: ../../../../../homepage/homepage.php");
            }
        }

        if(isset($_POST['submit'])){
            if(isset($_POST['nombre']) and isset($_POST['pwd'])){               
                verificarDatos($_POST['nombre'],$_POST['pwd']);
            }
        }
    ?>
</body>
</html>
