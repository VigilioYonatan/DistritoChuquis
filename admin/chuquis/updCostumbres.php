<?php

$errores = [];

$queryCostumbre = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'CHU-COD'");
$resultadoQuery = mysqli_fetch_assoc($queryCostumbre);

$costumbreFoto = $resultadoQuery['chuquis_foto'];
$costumbreVideo = $resultadoQuery['chuquis_video'];


if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $costumbre_welcome =    $_FILES['costumbre_welcome'];
    $costumbre_wallpaper =    $_FILES['costumbre_wallpaper'];
  
   

    if($costumbre_welcome['size'] > 2000000){
        $errores['fotoPesado'] = 'Imagen Muy pesado, max de 2MB';
    }

    if( $costumbre_welcome['type'] !== 'image/jpeg' && $costumbre_welcome['type'] !== 'image/jpg' && $costumbre_welcome['type'] !== 'image/png' && $costumbre_welcome['type'] !== 'image/webp' && !$costumbre_welcome['error']){
        $errores['fotoNoDisponible'] = 'Imagen no disponible, Solo formatos imagenes';
    }

    
    if($costumbre_wallpaper['size'] > 40000000){
        $errores['videoPesado'] = 'Video muy pesado, max de 40MB';
    }

    if( $costumbre_wallpaper['type'] !== 'video/mp4' && !$costumbre_wallpaper['error']){
        $errores['videoNoDisponible'] = 'Video no disponible, Solo MP4';
    }

    if(empty($errores)){
        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $mediaCostumbre = '/costumbres/';

        //crear carpeta si no exister
        if(!is_dir($carpetaMediaBD.$mediaCostumbre)){
            mkdir($carpetaMediaBD.$mediaCostumbre);
        }

        

        
        //actualizar foto welcome
        $nombreImagen = '';
        // si pone una imagen el usuario
        if($costumbre_welcome['name']){
                unlink($carpetaMediaBD.$mediaCostumbre.$costumbreFoto);

                //hasheeamos el nombre de la imagen
                $nombreImagen = md5( uniqid( rand(), true)).".jpg";
    
                move_uploaded_file($costumbre_welcome['tmp_name'], $carpetaMediaBD.$mediaCostumbre.$nombreImagen);     
        }else{
            $nombreImagen = $costumbreFoto;
        }

        //actualizar video Wallpaper
        $nombreVideo = '';
        // si pone una video  el usuario
        if($costumbre_wallpaper['name']){
                unlink($carpetaMediaBD.$mediaCostumbre.$costumbreVideo);

                //hasheeamos el nombre de la imagen
                $nombreVideo = md5( uniqid( rand(), true)).".mp4";
    
                move_uploaded_file($costumbre_wallpaper['tmp_name'], $carpetaMediaBD.$mediaCostumbre.$nombreVideo);     
        }else{
            $nombreVideo = $costumbreVideo;
        }

     
        
        $updateCostumbre = mysqli_query($cnx, "UPDATE chuquis SET chuquis_foto = '$nombreImagen', chuquis_video = '$nombreVideo' WHERE chuquis_cod = 'CHU-COD'"); 

        
        if($updateCostumbre){
            header('Location: index.php?action=updCostumbres&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">

    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title"> Cambiar Welcome & Wallpaper Costumbres</h2>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="costumbre_welcome"><i class="fas fa-image"></i> Foto Welcome</label>
            <input  class="configuracion-file" type="file" accept="image/*" name="costumbre_welcome" id="costumbre_welcome">
            <?php if(isset($errores['fotoNoDisponible'])): ?>
                <span class="error-process"><?php echo $errores['fotoNoDisponible']; ?></span>
            <?php  endif;?>
            <?php if(isset($errores['fotoPesado'])): ?>
                <span class="error-process"><?php echo $errores['fotoPesado']; ?></span>
            <?php  endif;?>
            <img width="100px" src="./mediaBD/mediaChuquis/costumbres/<?php echo $costumbreFoto; ?>" alt="">
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="costumbre_wallpaper"><i class="fas fa-video"></i> VIDEO WALLPAPER</label>
            <input  class="configuracion-file" type="file" name="costumbre_wallpaper" accept="video/*" id="costumbre_wallpaper">
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