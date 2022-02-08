<?php

$errores = [];

$querySitiosarqueologicos = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'CHU-STA'");
$resultadoQuery = mysqli_fetch_assoc($querySitiosarqueologicos);

$sitiosarqueologicosFoto = $resultadoQuery['chuquis_foto'];
$sitiosarqueologicosVideo = $resultadoQuery['chuquis_video'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $sitiosarqueologicos_welcome =    $_FILES['sitiosarqueologicos_welcome'];
    $sitiosarqueologicos_wallpaper =    $_FILES['sitiosarqueologicos_wallpaper'];
  
    $errores = validarFormularioWelcome($errores,$sitiosarqueologicos_welcome, $sitiosarqueologicos_wallpaper );
    
    if(empty($errores)){
        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $mediasitiosarqueologicos = '/chuquis/';

        //crear carpeta si no exister
        if(!is_dir($carpetaMediaBD.$mediasitiosarqueologicos)){
            mkdir($carpetaMediaBD.$mediasitiosarqueologicos);
        }

        //actualizar foto welcome
        $nombreImagen = '';
        // si pone una imagen el usuario
        if($sitiosarqueologicos_welcome['name']){
            unlink($carpetaMediaBD.$mediasitiosarqueologicos.$sitiosarqueologicosFoto);

            //hasheeamos el nombre de la imagen
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
    
            move_uploaded_file($sitiosarqueologicos_welcome['tmp_name'], $carpetaMediaBD.$mediasitiosarqueologicos.$nombreImagen);     
        }else{
            $nombreImagen = $sitiosarqueologicosFoto;
        }

        //actualizar video Wallpaper
        $nombreVideo = '';
        // si pone una video  el usuario
        if($sitiosarqueologicos_wallpaper['name']){
                unlink($carpetaMediaBD.$mediasitiosarqueologicos.$sitiosarqueologicosVideo);

                //hasheeamos el nombre de la imagen
                $nombreVideo = md5( uniqid( rand(), true)).".mp4";
    
                move_uploaded_file($sitiosarqueologicos_wallpaper['tmp_name'], $carpetaMediaBD.$mediasitiosarqueologicos.$nombreVideo);     
        }else{
            $nombreVideo = $sitiosarqueologicosVideo;
        }
      
        $updatesitiosarqueologicos = mysqli_query($cnx, "UPDATE chuquis SET chuquis_foto = '$nombreImagen', chuquis_video = '$nombreVideo' WHERE chuquis_cod = 'CHU-STA'"); 

        if($updatesitiosarqueologicos){
            header('Location: index.php?action=updSitiosarqueologicos&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">

    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title"> Cambiar Welcome & Wallpaper Sitios Arqueologicos</h2>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="sitiosarqueologicos_welcome"><i class="fas fa-image"></i> Foto Welcome</label>
            <input  class="configuracion-file" type="file" accept="image/*" name="sitiosarqueologicos_welcome" id="sitiosarqueologicos_welcome">
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : ''; ?>
            <img width="100px" src="./mediaBD/mediaChuquis/chuquis/<?php echo $sitiosarqueologicosFoto; ?>" alt="">
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="sitiosarqueologicos_wallpaper"><i class="fas fa-video"></i> VIDEO WALLPAPER</label>
            <input  class="configuracion-file" type="file" name="sitiosarqueologicos_wallpaper" accept="video/*" id="sitiosarqueologicos_wallpaper">
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