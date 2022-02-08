<?php


$errores = [];

$geografiaNombre  = '';
$geografiaTexto = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $geografiaNombre = mysqli_escape_string($cnx, trim($_POST['geografia_nombre']));
    $geografiaTexto = mysqli_escape_string($cnx, trim($_POST['geografia_texto']));
    $geografiaFoto = $_FILES['geografia_foto'];

    //validar Formulario
    $errores = validarFormulario($errores,$geografiaNombre, $geografiaTexto, $geografiaFoto, $upd = false);

    // si ya no hay errores
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $geografiaImagenes   = '/geografia/';

        // crear carpeta si no existe
        if(!is_dir($carpetaMediaBD.$geografiaImagenes)){
            mkdir($carpetaMediaBD.$geografiaImagenes);
        }

        $nombreImagen = md5( uniqid( rand(), true)).".jpg";
        move_uploaded_file($geografiaFoto['tmp_name'], $carpetaMediaBD.$geografiaImagenes.$nombreImagen); 


        $chuquisCod = 'CHU-GEO';
        $codigoGeografia = date('Y'.'m'.'d'.'s');
        $fechaGeografia = date('Y/m/d');

        $addGeografia  = mysqli_query($cnx, "INSERT INTO chuquis_tables (cod, nombre, texto, foto,fecha,ChuquisCod) VALUES ('$codigoGeografia','$geografiaNombre','$geografiaTexto', '$nombreImagen','$fechaGeografia', '$chuquisCod')");
      
        
        if($addGeografia){
            header('Location: index.php?action=createGeografia&agregado=1');
        }
    }   
    
}

?>
<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Geografías</h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="geografia_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $geografiaNombre; ?>" name="geografia_nombre" placeholder="Titulo">
            <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : ''; ?>
            <?php echo isset($errores['nombreLargo']) ? "<span class=error-process'>$errores[nombreLargo]></span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="geografia_texto">Texto de la imagen</label>
            <textarea class="configuracion-input" name="geografia_texto"><?php echo $geografiaTexto; ?></textarea>
            <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp-foto">
            <label class="configuracion-lbl-file"  for="geografia_foto">Imagen</label>
            <input  class="configuracion-file" type="file" name="geografia_foto" accept="image/*" id="geografia_foto" >
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : ''; ?>
        </div>
        <input class="configuracion-submit" type="submit" value="Agregar">

        <?php
            $actualizadoCorrectamente = $_GET['agregado']  ?? null;
            if($actualizadoCorrectamente == 1 && empty($errores)):
         ?>
         <span class="success-process">Agregado Correctamente <a href="index.php?action=readGeografia">Ver Agregado</a> </span>
         <?php endif; ?>
    </form>
</section>