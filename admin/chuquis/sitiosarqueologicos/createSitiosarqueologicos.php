<?php


$errores = [];

$sitiosarqueologicosNombre  = '';
$sitiosarqueologicosTexto = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $sitiosarqueologicosNombre = mysqli_escape_string($cnx, trim($_POST['sitiosarqueologicos_nombre']));
    $sitiosarqueologicosTexto = mysqli_escape_string($cnx, trim($_POST['sitiosarqueologicos_texto']));
    $sitiosarqueologicosFoto = $_FILES['sitiosarqueologicos_foto'];

    //validar Formulario
    $errores = validarFormulario($errores,$sitiosarqueologicosNombre, $sitiosarqueologicosTexto, $sitiosarqueologicosFoto, $upd = false);

    // si ya no hay errores
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $sitiosarqueologicosImagenes   = '/sitiosarqueologicos/';

        // crear carpeta si no existe
        if(!is_dir($carpetaMediaBD.$sitiosarqueologicosImagenes)){
            mkdir($carpetaMediaBD.$sitiosarqueologicosImagenes);
        }

        $nombreImagen = md5( uniqid( rand(), true)).".jpg";
        move_uploaded_file($sitiosarqueologicosFoto['tmp_name'], $carpetaMediaBD.$sitiosarqueologicosImagenes.$nombreImagen); 


        $chuquisCod = 'CHU-STA';
        $codigoSitiosarqueologicos = strtotime(date('c')).date('ymd'); // codigo generador
        $fechaSitiosarqueologicos = date('Y/m/d');
        $ruta = 'mediaChuquis/sitiosarqueologicos';
        $addSitiosarqueologicos  = mysqli_query($cnx, "INSERT INTO chuquis_tables (cod, nombre, texto, foto,fecha, ChuquisCod, ruta) VALUES ('$codigoSitiosarqueologicos','$sitiosarqueologicosNombre','$sitiosarqueologicosTexto', '$nombreImagen','$fechaSitiosarqueologicos', '$chuquisCod', '$ruta')");
     
        
        if($addSitiosarqueologicos){
            header('Location: index.php?action=createSitiosarqueologicos&agregado=1');
        }
    }   
    
}

?>
<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Sitios Arqueologicos</h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="sitiosarqueologicos_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $sitiosarqueologicosNombre; ?>" name="sitiosarqueologicos_nombre" placeholder="Titulo">
            <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : ''; ?>
            <?php echo isset($errores['nombreLargo']) ? "<span class=error-process'>$errores[nombreLargo]></span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="sitiosarqueologicos_texto">Texto de la imagen</label>
            <textarea class="configuracion-input" name="sitiosarqueologicos_texto"><?php echo $sitiosarqueologicosTexto; ?></textarea>
            <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp-foto">
            <label class="configuracion-lbl-file"  for="sitiosarqueologicos_foto">Imagen</label>
            <input  class="configuracion-file" type="file" name="sitiosarqueologicos_foto" accept="image/*" id="sitiosarqueologicos_foto" >
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : ''; ?>
        </div>
        <input class="configuracion-submit" type="submit" value="Agregar">

        <?php
            $actualizadoCorrectamente = $_GET['agregado']  ?? null;
            if($actualizadoCorrectamente == 1 && empty($errores)):
         ?>
         <span class="success-process">Agregado Correctamente <a href="index.php?action=readSitiosarqueologicos">Ver Agregado</a> </span>
         <?php endif; ?>
    </form>
</section>