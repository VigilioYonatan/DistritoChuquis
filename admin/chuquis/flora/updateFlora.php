<?php

$floraCod = $_GET['floraCod'];
$errores = [];


$queryflora = mysqli_query($cnx, "SELECT * FROM flora WHERE flora_cod = '$floraCod'");
$resultadoQuery = mysqli_fetch_assoc($queryflora);

$floraNombre    = $resultadoQuery['flora_nombre'];
$floraTexto     = $resultadoQuery['flora_texto'];
$floraFoto      = $resultadoQuery['flora_foto'];
$floraFecha     = $resultadoQuery['flora_fecha'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $flora_Nombre = mysqli_escape_string($cnx, trim($_POST['flora_nombre'])); 
    $flora_Texto = mysqli_escape_string($cnx, trim($_POST['flora_texto'])); 
    $flora_Foto = $_FILES['flora_foto'];

    // validar formulario
    $errores = validarFormulario($errores,$flora_Nombre , $flora_Texto, $flora_Foto, true);
    
   
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $floraImagenes   = '/flora/';

        $nombreImagen = '';

        if($flora_Foto['name']){
            unlink($carpetaMediaBD.$floraImagenes.$floraFoto );
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
            move_uploaded_file($flora_Foto['tmp_name'], $carpetaMediaBD.$floraImagenes.$nombreImagen); 
        }else{
            $nombreImagen = $floraFoto ;
        }


        $updflora  = mysqli_query($cnx, "UPDATE flora SET flora_nombre = '$flora_Nombre', flora_texto ='$flora_Texto', flora_foto = '$nombreImagen' WHERE flora_cod = '$floraCod'"); //$userCod hereda de index.php
      
        
        if($updflora){
            header('Location: index.php?action=readFlora&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Editar Flora de <?php echo $floraCod; ?></h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="flora_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $floraNombre; ?>" name="flora_nombre" placeholder="Titulo">
                <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : '' ?>
                <?php echo isset($errores['nombreLargo']) ? "<span class='error-process'>$errores[nombreLargo]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="flora_texto">Texto de la imagen</label>
            <textarea class="configuracion-textArea" name="flora_texto"><?php echo $floraTexto; ?></textarea>
                <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : '';?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="flora_foto"><i class="fas fa-image"></i> Imagen</label>
            <input  class="configuracion-file" accept="image/*" type="file" name="flora_foto" id="flora_foto" >
            <img width="200px" src="./mediaBD/mediaChuquis/flora/<?php echo $floraFoto; ?>" alt="">
            
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