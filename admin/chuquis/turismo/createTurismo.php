<?php


$errores = [];

$turismoNombre  = '';
$turismoTexto = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $turismoNombre = mysqli_escape_string($cnx, trim($_POST['turismo_nombre']));
    $turismoTexto = mysqli_escape_string($cnx, trim($_POST['turismo_texto']));
    $turismoFoto = $_FILES['turismo_foto'];

    //validar Formulario
    $errores = validarFormulario($errores,$turismoNombre, $turismoTexto, $turismoFoto, $upd = false);

    // si ya no hay errores
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $turismoImagenes   = '/turismo/';

        // crear carpeta si no existe
        if(!is_dir($carpetaMediaBD.$turismoImagenes)){
            mkdir($carpetaMediaBD.$turismoImagenes);
        }

        $nombreImagen = md5( uniqid( rand(), true)).".jpg";
        move_uploaded_file($turismoFoto['tmp_name'], $carpetaMediaBD.$turismoImagenes.$nombreImagen); 


        $chuquisCod = 'CHU-TUR';
        $codigoTurismo = strtotime(date('c')).date('ymd'); // codigo generador
        $fechaTurismo = date('Y/m/d');
        $ruta = 'mediaChuquis/turismo';

        $addTurismo  = mysqli_query($cnx, "INSERT INTO chuquis_tables (cod, nombre, texto, foto, fecha, ChuquisCod) VALUES ('$codigoTurismo','$turismoNombre','$turismoTexto', '$nombreImagen','$fechaTurismo', '$chuquisCod','$ruta')");
      
        
        if($addTurismo){
            header('Location: index.php?action=createTurismo&agregado=1');
        }
    }   
    
}

?>
<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Turismo</h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="turismo_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $turismoNombre; ?>" name="turismo_nombre" placeholder="Titulo">
            <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : ''; ?>
            <?php echo isset($errores['nombreLargo']) ? "<span class=error-process'>$errores[nombreLargo]></span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="turismo_texto">Texto de la imagen</label>
            <textarea class="configuracion-input" name="turismo_texto"><?php echo $turismoTexto; ?></textarea>
            <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp-foto">
            <label class="configuracion-lbl-file"  for="turismo_foto">Imagen</label>
            <input  class="configuracion-file" type="file" name="turismo_foto" accept="image/*" id="turismo_foto" >
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : ''; ?>
        </div>
        <input class="configuracion-submit" type="submit" value="Agregar">

        <?php
            $actualizadoCorrectamente = $_GET['agregado']  ?? null;
            if($actualizadoCorrectamente == 1 && empty($errores)):
         ?>
         <span class="success-process">Agregado Correctamente <a href="index.php?action=readTurismo">Ver Agregado</a> </span>
         <?php endif; ?>
    </form>
</section>