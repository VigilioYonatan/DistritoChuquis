<?php


$errores = [];

$carnavalesNombre  = '';
$carnavalesTexto = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $carnavalesNombre = mysqli_escape_string($cnx, trim($_POST['carnavales_nombre']));
    $carnavalesTexto = mysqli_escape_string($cnx, trim($_POST['carnavales_texto']));
    $carnavalesFoto = $_FILES['carnavales_foto'];

    //validar Formulario
    $errores = validarFormulario($errores,$carnavalesNombre, $carnavalesTexto, $carnavalesFoto, $upd = false);

    // si ya no hay errores
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $carnavalesImagenes   = '/carnavales/';

        // crear carpeta si no existe
        if(!is_dir($carpetaMediaBD.$carnavalesImagenes)){
            mkdir($carpetaMediaBD.$carnavalesImagenes);
        }

        $nombreImagen = md5( uniqid( rand(), true)).".jpg";
        move_uploaded_file($carnavalesFoto['tmp_name'], $carpetaMediaBD.$carnavalesImagenes.$nombreImagen); 


        $chuquisCod = 'CHU-CAR';
        $codigoCarnavales = strtotime(date('c')).date('ymd'); // codigo generador
        $fechaCarnavales = date('Y/m/d');
        $ruta = 'mediaChuquis/carnavales';

        $addCarnavales  = mysqli_query($cnx, "INSERT INTO chuquis_tables (cod, nombre, texto, foto, fecha, ChuquisCod, ruta) VALUES ('$codigoCarnavales','$carnavalesNombre','$carnavalesTexto', '$nombreImagen','$fechaCarnavales', '$chuquisCod', '$ruta')");

        
        if($addCarnavales){
            header('Location: index.php?action=createCarnavales&agregado=1');
        }
    }   
    
}

?>
<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Carnavales</h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="carnavales_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $carnavalesNombre; ?>" name="carnavales_nombre" placeholder="Titulo">
            <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : ''; ?>
            <?php echo isset($errores['nombreLargo']) ? "<span class=error-process'>$errores[nombreLargo]></span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="carnavales_texto">Texto de la imagen</label>
            <textarea class="configuracion-input" name="carnavales_texto"><?php echo $carnavalesTexto; ?></textarea>
            <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp-foto">
            <label class="configuracion-lbl-file"  for="carnavales_foto">Imagen</label>
            <input  class="configuracion-file" type="file" name="carnavales_foto" accept="image/*" id="carnavales_foto" >
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : ''; ?>
        </div>
        <input class="configuracion-submit" type="submit" value="Agregar">

        <?php
            $actualizadoCorrectamente = $_GET['agregado']  ?? null;
            if($actualizadoCorrectamente == 1 && empty($errores)):
         ?>
         <span class="success-process">Agregado Correctamente <a href="index.php?action=readCarnavales">Ver Agregado</a> </span>
         <?php endif; ?>
    </form>
</section>