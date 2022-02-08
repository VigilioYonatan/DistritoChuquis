<?php

$sitiosarqueologicosCod = $_GET['sitiosarqueologicosCod'];
$errores = [];


$querysitiosarqueologicos = mysqli_query($cnx, "SELECT * FROM sitiosarqueologicos WHERE sitiosarqueologicos_cod = '$sitiosarqueologicosCod'");
$resultadoQuery = mysqli_fetch_assoc($querysitiosarqueologicos);

$sitiosarqueologicosNombre    = $resultadoQuery['sitiosarqueologicos_nombre'];
$sitiosarqueologicosTexto     = $resultadoQuery['sitiosarqueologicos_texto'];
$sitiosarqueologicosFoto      = $resultadoQuery['sitiosarqueologicos_foto'];
$sitiosarqueologicosFecha     = $resultadoQuery['sitiosarqueologicos_fecha'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $sitiosarqueologicos_Nombre = mysqli_escape_string($cnx, trim($_POST['sitiosarqueologicos_nombre'])); 
    $sitiosarqueologicos_Texto = mysqli_escape_string($cnx, trim($_POST['sitiosarqueologicos_texto'])); 
    $sitiosarqueologicos_Foto = $_FILES['sitiosarqueologicos_foto'];

    // validar formulario
    $errores = validarFormulario($errores,$sitiosarqueologicos_Nombre , $sitiosarqueologicos_Texto, $sitiosarqueologicos_Foto, true);
    
   
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $sitiosarqueologicosImagenes   = '/sitiosarqueologicos/';

        $nombreImagen = '';

        if($sitiosarqueologicos_Foto['name']){
            unlink($carpetaMediaBD.$sitiosarqueologicosImagenes.$sitiosarqueologicosFoto );
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
            move_uploaded_file($sitiosarqueologicos_Foto['tmp_name'], $carpetaMediaBD.$sitiosarqueologicosImagenes.$nombreImagen); 
        }else{
            $nombreImagen = $sitiosarqueologicosFoto ;
        }


        $updsitiosarqueologicos  = mysqli_query($cnx, "UPDATE sitiosarqueologicos SET sitiosarqueologicos_nombre = '$sitiosarqueologicos_Nombre', sitiosarqueologicos_texto ='$sitiosarqueologicos_Texto', sitiosarqueologicos_foto = '$nombreImagen' WHERE sitiosarqueologicos_cod = '$sitiosarqueologicosCod'"); //$userCod hereda de index.php
      
        
        if($updsitiosarqueologicos){
            header('Location: index.php?action=readSitiosarqueologicos&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Editar Sitios Arqueologicos de <?php echo $sitiosarqueologicosCod; ?></h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="sitiosarqueologicos_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $sitiosarqueologicosNombre; ?>" name="sitiosarqueologicos_nombre" placeholder="Titulo">
                <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : '' ?>
                <?php echo isset($errores['nombreLargo']) ? "<span class='error-process'>$errores[nombreLargo]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="sitiosarqueologicos_texto">Texto de la imagen</label>
            <textarea class="configuracion-textArea" name="sitiosarqueologicos_texto"><?php echo $sitiosarqueologicosTexto; ?></textarea>
                <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : '';?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="sitiosarqueologicos_foto"><i class="fas fa-image"></i> Imagen</label>
            <input  class="configuracion-file" accept="image/*" type="file" name="sitiosarqueologicos_foto" id="sitiosarqueologicos_foto" >
            <img width="200px" src="./mediaBD/mediaChuquis/sitiosarqueologicos/<?php echo $sitiosarqueologicosFoto; ?>" alt="">
            
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : '';?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : '';?>
        </div>
        <input class="configuracion-submit" type="submit" value="Actualizar">

        <?php
            $actualizadoCorrectamente = $_GET['actualizado']  ?? null;
            if($actualizadoCorrectamente == 1 && empty($errores)):
         ?>
         <span class="success-process">Actualizado Correctamente</span>
         <?php endif; ?>
    </form>
</section>