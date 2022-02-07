<?php

$errores = [];

$queryFauna = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'CHU-FAU'");
$resultadoQuery = mysqli_fetch_assoc($queryFauna);

$faunaFoto = $resultadoQuery['chuquis_foto'];
$faunaVideo = $resultadoQuery['chuquis_video'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $fauna_welcome =    $_FILES['fauna_welcome'];
    $fauna_wallpaper =    $_FILES['fauna_wallpaper'];
  
    $errores = validarFormularioWelcome($errores,$fauna_welcome, $fauna_wallpaper );
    
    if(empty($errores)){
        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $mediafauna = '/fauna/';

        //crear carpeta si no exister
        if(!is_dir($carpetaMediaBD.$mediafauna)){
            mkdir($carpetaMediaBD.$mediafauna);
        }

        //actualizar foto welcome
        $nombreImagen = '';
        // si pone una imagen el usuario
        if($fauna_welcome['name']){
            unlink($carpetaMediaBD.$mediafauna.$faunaFoto);

            //hasheeamos el nombre de la imagen
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
    
            move_uploaded_file($fauna_welcome['tmp_name'], $carpetaMediaBD.$mediafauna.$nombreImagen);     
        }else{
            $nombreImagen = $faunaFoto;
        }

        //actualizar video Wallpaper
        $nombreVideo = '';
        // si pone una video  el usuario
        if($fauna_wallpaper['name']){
                unlink($carpetaMediaBD.$mediafauna.$faunaVideo);

                //hasheeamos el nombre de la imagen
                $nombreVideo = md5( uniqid( rand(), true)).".mp4";
    
                move_uploaded_file($fauna_wallpaper['tmp_name'], $carpetaMediaBD.$mediafauna.$nombreVideo);     
        }else{
            $nombreVideo = $faunaVideo;
        }
      
        $updatefauna = mysqli_query($cnx, "UPDATE chuquis SET chuquis_foto = '$nombreImagen', chuquis_video = '$nombreVideo' WHERE chuquis_cod = 'CHU-FAU'"); 

        if($updatefauna){
            header('Location: index.php?action=updFauna&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">

    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title"> Cambiar Welcome & Wallpaper Fauna</h2>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="fauna_welcome"><i class="fas fa-image"></i> Foto Welcome</label>
            <input  class="configuracion-file" type="file" accept="image/*" name="fauna_welcome" id="fauna_welcome">
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : ''; ?>
            <img width="100px" src="./mediaBD/mediaChuquis/fauna/<?php echo $faunaFoto; ?>" alt="">
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="fauna_wallpaper"><i class="fas fa-video"></i> VIDEO WALLPAPER</label>
            <input  class="configuracion-file" type="file" name="fauna_wallpaper" accept="video/*" id="fauna_wallpaper">
            <span>VIdeo MAXIMO de 40MB</span>
            <?php echo isset($errores['videoNoDisponible']) ? "<span class='error-process'>$errores[videoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['videoPesado']) ? "<span class='error-process'>$errores[videoPesado]</span>" : '' ?>
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