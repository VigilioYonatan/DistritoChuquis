<?php


$errores = [];

$floraNombre  = '';
$floraTexto = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $floraNombre = mysqli_escape_string($cnx, trim($_POST['flora_nombre']));
    $floraTexto = mysqli_escape_string($cnx, trim($_POST['flora_texto']));
    $floraFoto = $_FILES['flora_foto'];

    //validar Formulario
    $errores = validarFormulario($errores,$floraNombre, $floraTexto, $floraFoto, $upd = false);

    // si ya no hay errores
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $floraImagenes   = '/flora/';

        // crear carpeta si no existe
        if(!is_dir($carpetaMediaBD.$floraImagenes)){
            mkdir($carpetaMediaBD.$floraImagenes);
        }

        $nombreImagen = md5( uniqid( rand(), true)).".jpg";
        move_uploaded_file($floraFoto['tmp_name'], $carpetaMediaBD.$floraImagenes.$nombreImagen); 


        $chuquisCod = 'CHU-FLO';
        $codigoFlora = strtotime(date('c')).date('ymd'); // codigo generador
        $fechaFlora = date('Y/m/d');
        $ruta = 'mediaChuquis/flora';
        $addFlora  = mysqli_query($cnx, "INSERT INTO chuquis_tables (cod, nombre, texto, foto,fecha, ChuquisCod, ruta) VALUES ('$codigoFlora','$floraNombre','$floraTexto', '$nombreImagen','$fechaFlora', '$chuquisCod', '$ruta')");
      
        
        if($addFlora){
            header('Location: index.php?action=createFlora&agregado=1');
        }
    }   
    
}

?>
<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Flora</h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="flora_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $floraNombre; ?>" name="flora_nombre" placeholder="Titulo">
            <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : ''; ?>
            <?php echo isset($errores['nombreLargo']) ? "<span class=error-process'>$errores[nombreLargo]></span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="flora_texto">Texto de la imagen</label>
            <textarea class="configuracion-input" name="flora_texto"><?php echo $floraTexto; ?></textarea>
            <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp-foto">
            <label class="configuracion-lbl-file"  for="flora_foto">Imagen</label>
            <input  class="configuracion-file" type="file" name="flora_foto" accept="image/*" id="flora_foto" >
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : ''; ?>
        </div>
        <input class="configuracion-submit" type="submit" value="Agregar">

        <?php
            $actualizadoCorrectamente = $_GET['agregado']  ?? null;
            if($actualizadoCorrectamente == 1 && empty($errores)):
         ?>
         <span class="success-process">Agregado Correctamente <a href="index.php?action=readFlora">Ver Agregado</a> </span>
         <?php endif; ?>
    </form>
</section>