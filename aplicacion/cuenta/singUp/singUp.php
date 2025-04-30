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
            <form name="formulario" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"> 
                <p>Nombre de usuario: </p>
                <input type="text" name="nombre">

                <p>Correo electrónico: </p>
                <input type="email" name="email">

                <p>Contraseña: </p>
                <input type="password" name="pwd">

                <p>Repite la contraseña: </p>
                <input type="password" name="pwdR">

                <br>
                <br>
                
                <button type="submit" name="submit">Sing Up</button>
                <button type="reset">Reset</button>
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

        function verificarEmail($email){
            $dsn="mysql:host=localhost;charset=utf8;dbname=honorandglory";
            $options=array(PDO::ATTR_PERSISTENT=>true);
            try{
                $db=new PDO($dsn,"root","",$options);
            }
            catch(PDOException $e){
                die("Error!: ". $e->getMessage()."<br>");
            }
            $query='select email from usuarios where email=?';
            $queryResultado=$db->prepare($query);
            $queryResultado->execute(array($email));
            while($match=$queryResultado->fetch(PDO::FETCH_ASSOC)){
                if($match!=null){
                    return false;
                }
            }
            return true;
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
                if($match!=null){
                    return false;
                }
            }
            return true;
        }

        function verificarPwd($pwd,$pwdR){
            if($pwd==$pwdR){
                return true;
            }else{
                return false;
            }
        }

        function registrarUsuario($email,$nombre,$pwd){
            $dsn ="mysql:host=localhost;dbname=honorandglory";
            $conn = new PDO( $dsn, 'root', '' );
            $datos=array(':email'=>$email, ':nombre'=>$nombre, ':pwd'=>$pwd);
            $sql = ' INSERT INTO usuarios (email,nombre,pwd)
            VALUES ( :email , :nombre, :pwd ) ' ;
            $q = $conn->prepare($sql);
            $q->execute($datos);
            $_SESSION['usuario']=new Jugador($nombre,0,0);
            header("Location: ../../../../../homepage/homepage.php");
        }

        function verificarDatos($email,$nombre,$pwd,$pwdR){
            if(!empty(filtrado($email)) and !empty(filtrado($nombre)) and !empty(filtrado($pwd)) and !empty(filtrado($pwdR))){
                $email=filtrado($_POST['email']);
                $nombre=filtrado($_POST['nombre']);
                $pwd=filtrado($_POST['pwd']);
                $pwdR=filtrado($_POST['pwdR']);
                if(verificarEmail($email) and verificarNombre($nombre) and verificarPwd($pwd,$pwdR)){
                    registrarUsuario($email,$nombre,$pwd);
                }else{
                    //Datos de inicio de sesion erroneos
                }
            }else{
                //Datos de inicio vacios uno o mas
            }
        }

        if(isset($_POST['submit'])){
            if(isset($_POST['email']) and isset($_POST['nombre']) and isset($_POST['pwd']) and isset($_POST['pwdR'])){
                verificarDatos($_POST['email'],$_POST['nombre'],$_POST['pwd'],$_POST['pwdR']);
            }
        }
    ?>
</body>
</html>
