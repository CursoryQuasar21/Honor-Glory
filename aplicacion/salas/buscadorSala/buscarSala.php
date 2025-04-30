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
            <h2>Buscar sala</h2>
            <form>
                <p>Código </p>
                <input type="number" name="eleccion">

                <br>
                <br>

                <button type="submit" name="submit" value="Join"></button>

            </form>
        </div>
    </div>

    <?php
        if(isset($_POST['submit'])){
            if(!empty($_POST['eleccion'])){
                //Corregir header
                header("Location: ");
            }else{
                //No ha seleccionado partida
            }
        }
    ?>
</body>
</html>