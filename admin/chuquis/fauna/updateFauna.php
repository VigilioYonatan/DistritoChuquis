<?php

$faunaCod = $_GET['faunaCod'];
$errores = [];


$queryfauna = mysqli_query($cnx, "SELECT * FROM fauna WHERE fauna_cod = '$faunaCod'");
$resultadoQuery = mysqli_fetch_assoc($queryfauna);

$faunaNombre    = $resultadoQuery['fauna_nombre'];
$faunaTexto     = $resultadoQuery['fauna_texto'];
$faunaFoto      = $resultadoQuery['fauna_foto'];
$faunaFecha     = $resultadoQuery['fauna_fecha'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $fauna_Nombre = mysqli_escape_string($cnx, trim($_POST['fauna_nombre'])); 
    $fauna_Texto = mysqli_escape_string($cnx, trim($_POST['fauna_texto'])); 
    $fauna_Foto = $_FILES['fauna_foto'];

    // validar formulario
    $errores = validarFormulario($errores,$fauna_Nombre , $fauna_Texto, $fauna_Foto, true);
    
   
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $faunaImagenes   = '/fauna/';

        $nombreImagen = '';

        if($fauna_Foto['name']){
            unlink($carpetaMediaBD.$faunaImagenes.$faunaFoto );
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
            move_uploaded_file($fauna_Foto['tmp_name'], $carpetaMediaBD.$faunaImagenes.$nombreImagen); 
        }else{
            $nombreImagen = $faunaFoto ;
        }


        $updfauna  = mysqli_query($cnx, "UPDATE fauna SET fauna_nombre = '$fauna_Nombre', fauna_texto ='$fauna_Texto', fauna_foto = '$nombreImagen' WHERE fauna_cod = '$faunaCod'"); //$userCod hereda de index.php
      
        
        if($updfauna){
            header('Location: index.php?action=readFauna&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Editar Fauna de <?php echo $faunaCod; ?></h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="fauna_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $faunaNombre; ?>" name="fauna_nombre" placeholder="Titulo">
                <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : '' ?>
                <?php echo isset($errores['nombreLargo']) ? "<span class='error-process'>$errores[nombreLargo]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="fauna_texto">Texto de la imagen</label>
            <textarea class="configuracion-textArea" name="fauna_texto"><?php echo $faunaTexto; ?></textarea>
                <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : '';?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="fauna_foto"><i class="fas fa-image"></i> Imagen</label>
            <input  class="configuracion-file" accept="image/*" type="file" name="fauna_foto" id="fauna_foto" >
            <img width="200px" src="./mediaBD/mediaChuquis/fauna/<?php echo $faunaFoto; ?>" alt="">
            
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