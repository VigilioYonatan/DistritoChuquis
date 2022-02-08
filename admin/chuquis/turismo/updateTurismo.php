<?php

$turismoCod = $_GET['turismoCod'];
$errores = [];


$queryturismo = mysqli_query($cnx, "SELECT * FROM chuquis_tables WHERE cod = '$turismoCod'");
$resultadoQuery = mysqli_fetch_assoc($queryturismo);

$turismoNombre    = $resultadoQuery['nombre'];
$turismoTexto     = $resultadoQuery['texto'];
$turismoFoto      = $resultadoQuery['foto'];
$turismoFecha     = $resultadoQuery['fecha'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $turismo_Nombre = mysqli_escape_string($cnx, trim($_POST['turismo_nombre'])); 
    $turismo_Texto = mysqli_escape_string($cnx, trim($_POST['turismo_texto'])); 
    $turismo_Foto = $_FILES['turismo_foto'];

    // validar formulario
    $errores = validarFormulario($errores,$turismo_Nombre , $turismo_Texto, $turismo_Foto, true);
    
   
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $turismoImagenes   = '/turismo/';

        $nombreImagen = '';

        if($turismo_Foto['name']){
            unlink($carpetaMediaBD.$turismoImagenes.$turismoFoto );
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
            move_uploaded_file($turismo_Foto['tmp_name'], $carpetaMediaBD.$turismoImagenes.$nombreImagen); 
        }else{
            $nombreImagen = $turismoFoto ;
        }


        $updturismo  = mysqli_query($cnx, "UPDATE chuquis_tables SET nombre = '$turismo_Nombre', texto ='$turismo_Texto', foto = '$nombreImagen' WHERE cod = '$turismoCod'"); //$userCod hereda de index.php
      
        
        if($updturismo){
            header('Location: index.php?action=readTurismo&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Editar Turismo de <?php echo $turismoCod; ?></h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="turismo_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $turismoNombre; ?>" name="turismo_nombre" placeholder="Titulo">
                <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : '' ?>
                <?php echo isset($errores['nombreLargo']) ? "<span class='error-process'>$errores[nombreLargo]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="turismo_texto">Texto de la imagen</label>
            <textarea class="configuracion-textArea" name="turismo_texto"><?php echo $turismoTexto; ?></textarea>
                <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : '';?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="turismo_foto"><i class="fas fa-image"></i> Imagen</label>
            <input  class="configuracion-file" accept="image/*" type="file" name="turismo_foto" id="turismo_foto" >
            <img width="200px" src="./mediaBD/mediaChuquis/turismo/<?php echo $turismoFoto; ?>" alt="">
            
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