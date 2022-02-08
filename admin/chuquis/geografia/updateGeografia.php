<?php

$geografiaCod = $_GET['geografiaCod'];
$errores = [];


$querygeografia = mysqli_query($cnx, "SELECT * FROM chuquis_tables WHERE cod = '$geografiaCod'");
$resultadoQuery = mysqli_fetch_assoc($querygeografia);

$geografiaNombre    = $resultadoQuery['nombre'];
$geografiaTexto     = $resultadoQuery['texto'];
$geografiaFoto      = $resultadoQuery['foto'];
$geografiaFecha     = $resultadoQuery['fecha'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $geografia_Nombre = mysqli_escape_string($cnx, trim($_POST['geografia_nombre'])); 
    $geografia_Texto = mysqli_escape_string($cnx, trim($_POST['geografia_texto'])); 
    $geografia_Foto = $_FILES['geografia_foto'];

    // validar formulario
    $errores = validarFormulario($errores,$geografia_Nombre , $geografia_Texto, $geografia_Foto, true);
    
   
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $geografiaImagenes   = '/geografia/';

        $nombreImagen = '';

        if($geografia_Foto['name']){
            unlink($carpetaMediaBD.$geografiaImagenes.$geografiaFoto );
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
            move_uploaded_file($geografia_Foto['tmp_name'], $carpetaMediaBD.$geografiaImagenes.$nombreImagen); 
        }else{
            $nombreImagen = $geografiaFoto ;
        }


        $updgeografia  = mysqli_query($cnx, "UPDATE chuquis_tables SET nombre = '$geografia_Nombre', texto ='$geografia_Texto', foto = '$nombreImagen' WHERE cod = '$geografiaCod'"); //$userCod hereda de index.php
      
        
        if($updgeografia){
            header('Location: index.php?action=readGeografia&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Editar Geografia de <?php echo $geografiaCod; ?></h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="geografia_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $geografiaNombre; ?>" name="geografia_nombre" placeholder="Titulo">
                <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : '' ?>
                <?php echo isset($errores['nombreLargo']) ? "<span class='error-process'>$errores[nombreLargo]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="geografia_texto">Texto de la imagen</label>
            <textarea class="configuracion-textArea" name="geografia_texto"><?php echo $geografiaTexto; ?></textarea>
                <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : '';?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="geografia_foto"><i class="fas fa-image"></i> Imagen</label>
            <input  class="configuracion-file" accept="image/*" type="file" name="geografia_foto" id="geografia_foto" >
            <img width="200px" src="./mediaBD/mediaChuquis/geografia/<?php echo $geografiaFoto; ?>" alt="">
            
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