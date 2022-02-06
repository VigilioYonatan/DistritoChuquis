<?php

$errores = [];

$queryInicio = mysqli_query($cnx, "SELECT * FROM inicio");
$resultadoQuery = mysqli_fetch_assoc($queryInicio);

$inicioWelcome = $resultadoQuery['inicio_welcomeFoto'];
$inicioWallpaper = $resultadoQuery['inicio_welcomeWallpaper'];


if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $inicio_welcome =    $_FILES['inicio_welcome'];
    $inicio_wallpaper =    $_FILES['inicio_wallpaper'];
  
   

    if($inicio_welcome['size'] > 2000000){
        $errores['fotoPesado'] = 'Imagen Muy pesado, max de 2MB';
    }

    if( $inicio_welcome['type'] !== 'image/jpeg' && $inicio_welcome['type'] !== 'image/jpg' && $inicio_welcome['type'] !== 'image/png' && $inicio_welcome['type'] !== 'image/webp' && !$inicio_welcome['error']){
        $errores['fotoNoDisponible'] = 'Imagen no disponible, Solo formatos imagenes';
    }

    
    if($inicio_wallpaper['size'] > 40000000){
        $errores['videoPesado'] = 'Video muy pesado, max de 40MB';
    }

    if( $inicio_wallpaper['type'] !== 'video/mp4' && !$inicio_wallpaper['error']){
        $errores['videoNoDisponible'] = 'Video no disponible, Solo MP4';
    }

    if(empty($errores)){
        $carpetaMediaBD = './mediaBD';
        $mediaInicio = '/mediaInicio/';

        //crear carpeta si no exister
        if(!is_dir($carpetaMediaBD.$mediaInicio)){
            mkdir($carpetaMediaBD.$mediaInicio);
        }

        

        
        //actualizar foto welcome
        $nombreImagen = '';
        // si pone una imagen el usuario
        if($inicio_welcome['name']){
                unlink($carpetaMediaBD.$mediaInicio.$inicioWelcome);

                //hasheeamos el nombre de la imagen
                $nombreImagen = md5( uniqid( rand(), true)).".jpg";
    
                move_uploaded_file($inicio_welcome['tmp_name'], $carpetaMediaBD.$mediaInicio.$nombreImagen);     
        }else{
            $nombreImagen = $inicioWelcome;
        }

        //actualizar video Wallpaper
        $nombreVideo = '';
        // si pone una video  el usuario
        if($inicio_wallpaper['name']){
                unlink($carpetaMediaBD.$mediaInicio.$inicioWallpaper);

                //hasheeamos el nombre de la imagen
                $nombreVideo = md5( uniqid( rand(), true)).".mp4";
    
                move_uploaded_file($inicio_wallpaper['tmp_name'], $carpetaMediaBD.$mediaInicio.$nombreVideo);     
        }else{
            $nombreVideo = $inicioWallpaper;
        }

     
        
        $updateWelcome  = mysqli_query($cnx, "UPDATE inicio SET inicio_welcomeFoto = '$nombreImagen', inicio_welcomeWallpaper = '$nombreVideo'"); 

        
        if($updateWelcome){
            header('Location: index.php?action=updateFotoWelcome&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">

    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title"> Cambiar Welcome & Wallpaper</h2>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="inicio_welcome"><i class="fas fa-image"></i> Foto Welcome</label>
            <input  class="configuracion-file" type="file" accept="image/*" name="inicio_welcome" id="inicio_welcome">
            <?php if(isset($errores['fotoNoDisponible'])): ?>
                <span class="error-process"><?php echo $errores['fotoNoDisponible']; ?></span>
            <?php  endif;?>
            <?php if(isset($errores['fotoPesado'])): ?>
                <span class="error-process"><?php echo $errores['fotoPesado']; ?></span>
            <?php  endif;?>
            <img width="100px" src="./mediaBD/mediaInicio/<?php echo $inicioWelcome; ?>" alt="">
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="inicio_wallpaper"><i class="fas fa-video"></i> VIDEO WALLPAPER INICIO</label>
            <input  class="configuracion-file" type="file" name="inicio_wallpaper" accept="video/*" id="inicio_wallpaper">
            <span>VIdeo MAXIMO de 40MB</span>
            <?php if(isset($errores['videoNoDisponible'])): ?>
                <span class="error-process"><?php echo $errores['videoNoDisponible']; ?></span>
            <?php  endif;?>
            <?php if(isset($errores['videoPesado'])): ?>
                <span class="error-process"><?php echo $errores['videoPesado']; ?></span>
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