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

   
    // var_dump($user_foto);
    // exit;
    if(!$flora_Nombre){
        $errores['nombreVacio'] = 'El nombre no debe estar Vacio';
    }

    if(strlen($flora_Nombre) > 50){
        $errores['nombreLargo'] = 'Nombre demasiado Largo max 50';
    }

    if(!$flora_Texto){
        $errores['textoVacio'] = 'El texto no debe estar vacio';
    }

 

    

  
    if($flora_Foto['size'] > 5000000){
        $errores['fotoPesado'] = 'Imagen Muy pesado, menos de 5MB';
    }



    if( $flora_Foto['type'] !== 'image/jpeg' && $flora_Foto['type'] !== 'image/jpg' && $flora_Foto['type'] !== 'image/png' && $flora_Foto['type'] !== 'image/webp' && !$flora_Foto['error']){
        $errores['fotoNoDisponible'] = 'Insertar Imagen obligatoriamente en formato imagen';
    }

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
            header('Location: index.php?action=readFlora');
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
            <?php if(isset($errores['nombreVacio'])):?>
                <span class="error-process"><?php echo $errores['nombreVacio']; ?></span>
            <?php endif; ?>
            <?php if(isset($errores['nombreLargo'])):?>
                <span class="error-process"><?php echo $errores['nombreLargo']; ?></span>
            <?php endif; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="flora_texto">Texto de la imagen</label>
            <textarea class="configuracion-textArea" name="flora_texto"><?php echo $floraTexto; ?></textarea>
            <?php if(isset($errores['textoVacio'])):?>
                <span class="error-process"><?php echo $errores['textoVacio']; ?></span>
            <?php endif; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="flora_foto"><i class="fas fa-image"></i> Imagen</label>
            <input  class="configuracion-file" accept="image/*" type="file" name="flora_foto" id="flora_foto" >
            <img width="200px" src="./mediaBD/mediaChuquis/flora/<?php echo $floraFoto; ?>" alt="">

            <?php if(isset($errores['fotoNoDisponible'])): ?>
                <span class="error-process"><?php echo $errores['fotoNoDisponible']; ?></span>
            <?php  endif;?>
            <?php if(isset($errores['fotoPesado'])): ?>
                <span class="error-process"><?php echo $errores['fotoPesado']; ?></span>
            <?php  endif;?>
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