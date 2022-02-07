<?php


$errores = [];

$faunaNombre  = '';
$faunaTexto = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $faunaNombre = mysqli_escape_string($cnx, trim($_POST['fauna_nombre']));
    $faunaTexto = mysqli_escape_string($cnx, trim($_POST['fauna_texto']));
    $faunaFoto = $_FILES['fauna_foto'];

    //validar Formulario
    $errores = validarFormulario($errores,$faunaNombre, $faunaTexto, $faunaFoto, $upd = false);

    // si ya no hay errores
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $faunaImagenes   = '/fauna/';

        // crear carpeta si no existe
        if(!is_dir($carpetaMediaBD.$faunaImagenes)){
            mkdir($carpetaMediaBD.$faunaImagenes);
        }

        $nombreImagen = md5( uniqid( rand(), true)).".jpg";
        move_uploaded_file($faunaFoto['tmp_name'], $carpetaMediaBD.$faunaImagenes.$nombreImagen); 


        $chuquisCod = 'CHU-TUR';
        $codigoFauna = date('Y'.'m'.'d'.'s');
        $fechaFauna = date('Y/m/d');

        $addFauna  = mysqli_query($cnx, "INSERT INTO fauna (fauna_cod, fauna_nombre, fauna_texto, fauna_foto,fauna_fecha, fauna_ChuquisCod) VALUES ('$codigoFauna','$faunaNombre','$faunaTexto', '$nombreImagen','$fechaFauna', '$chuquisCod')");
      
        
        if($addFauna){
            header('Location: index.php?action=createFauna&agregado=1');
        }
    }   
    
}

?>
<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Fauna</h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="fauna_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $faunaNombre; ?>" name="fauna_nombre" placeholder="Titulo">
            <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : ''; ?>
            <?php echo isset($errores['nombreLargo']) ? "<span class=error-process'>$errores[nombreLargo]></span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="fauna_texto">Texto de la imagen</label>
            <textarea class="configuracion-input" name="fauna_texto"><?php echo $faunaTexto; ?></textarea>
            <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp-foto">
            <label class="configuracion-lbl-file"  for="fauna_foto">Imagen</label>
            <input  class="configuracion-file" type="file" name="fauna_foto" accept="image/*" id="fauna_foto" >
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : ''; ?>
        </div>
        <input class="configuracion-submit" type="submit" value="Agregar">

        <?php
            $actualizadoCorrectamente = $_GET['agregado']  ?? null;
            if($actualizadoCorrectamente == 1 && empty($errores)):
         ?>
         <span class="success-process">Agregado Correctamente <a href="index.php?action=readFauna">Ver Agregado</a> </span>
         <?php endif; ?>
    </form>
</section>