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
        
        include_once "../../entidades/partida/partida.php";

        function partidaExiste($id){
            $dsn="mysql:host=localhost;charset=utf8;dbname=honorandglory";
            $options=array(PDO::ATTR_PERSISTENT=>true);
            try{
                $db=new PDO($dsn,"root","",$options);
            }
            catch(PDOException $e){
                die("Error!: ". $e->getMessage()."<br>");
            }
            $query='select id from partidas where id=?';
            $queryResultado=$db->prepare($query);
            $queryResultado->execute(array($id));
            while($match=$queryResultado->fetch(PDO::FETCH_ASSOC)){
                if($match['id']==$id){
                    return true;
                }
            }
            return false;

        }
        function registroPartida($partida){
            $dsn ="mysql:host=localhost;dbname=honorandglory";
            try {
                $conn = new PDO( $dsn, 'root', '' );
            } catch ( PDOException $e) { 
                die( "¡Error!: " . $e->getMessage() . "<br/>"); 
            }
            if(partidaExiste($partida->getId())){
                $datos=array(':id'=>$partida->getId(), ':rondas'=>$partida->getRondas(),
                                ':marcador1'=>$partida->getMarcador()[0],
                                ':marcador2'=>$partida->getMarcador()[1],
                                ':jugador1_id'=>$partida->getJugadores()[0]->getId());
                $sql = ' UPDATE partidas SET  rondas=:rondas,marcador1=:marcador1,marcador2=:marcador2,jugador1_id=:jugador1_id  WHERE id=:id ' ;
                $q = $conn->prepare($sql);
                $q->execute($datos);
            }else{
                $datos=array(':rondas'=>$partida->getRondas(),
                                ':marcador1'=>$partida->getMarcador()[0],
                                ':marcador2'=>$partida->getMarcador()[1],
                                ':jugador1_id'=>$partida->getJugadores()[0]->getId());
                $sql = ' INSERT INTO partidas (rondas,marcador1,marcador2,jugador1_id)
                VALUES ( :marcador1,:marcador2,:jugador1_id ) ' ;
                $q = $conn->prepare($sql);
                return $q->execute($datos);
            }
        }

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
                registroPartida($partida);
            }
        }
        else
            header("Location: ../../cuenta/singIn/singIn.php");
    ?>
</body>
</html>