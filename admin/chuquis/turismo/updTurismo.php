<?php

$errores = [];

$queryTurismo = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'CHU-TUR'");
$resultadoQuery = mysqli_fetch_assoc($queryTurismo);

$turismoFoto = $resultadoQuery['chuquis_foto'];
$turismoVideo = $resultadoQuery['chuquis_video'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $turismo_welcome =    $_FILES['turismo_welcome'];
    $turismo_wallpaper =    $_FILES['turismo_wallpaper'];
  
    $errores = validarFormularioWelcome($errores,$turismo_welcome, $turismo_wallpaper );
    
    if(empty($errores)){
        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $mediaturismo = '/turismo/';

        //crear carpeta si no exister
        if(!is_dir($carpetaMediaBD.$mediaturismo)){
            mkdir($carpetaMediaBD.$mediaturismo);
        }

        //actualizar foto welcome
        $nombreImagen = '';
        // si pone una imagen el usuario
        if($turismo_welcome['name']){
            unlink($carpetaMediaBD.$mediaturismo.$turismoFoto);

            //hasheeamos el nombre de la imagen
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
    
            move_uploaded_file($turismo_welcome['tmp_name'], $carpetaMediaBD.$mediaturismo.$nombreImagen);     
        }else{
            $nombreImagen = $turismoFoto;
        }

        //actualizar video Wallpaper
        $nombreVideo = '';
        // si pone una video  el usuario
        if($turismo_wallpaper['name']){
                unlink($carpetaMediaBD.$mediaturismo.$turismoVideo);

                //hasheeamos el nombre de la imagen
                $nombreVideo = md5( uniqid( rand(), true)).".mp4";
    
                move_uploaded_file($turismo_wallpaper['tmp_name'], $carpetaMediaBD.$mediaturismo.$nombreVideo);     
        }else{
            $nombreVideo = $turismoVideo;
        }
      
        $updateturismo = mysqli_query($cnx, "UPDATE chuquis SET chuquis_foto = '$nombreImagen', chuquis_video = '$nombreVideo' WHERE chuquis_cod = 'CHU-TUR'"); 

        if($updateturismo){
            header('Location: index.php?action=updTurismo&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">

    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title"> Cambiar Welcome & Wallpaper Turismo</h2>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="turismo_welcome"><i class="fas fa-image"></i> Foto Welcome</label>
            <input  class="configuracion-file" type="file" accept="image/*" name="turismo_welcome" id="turismo_welcome">
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : ''; ?>
            <img width="100px" src="./mediaBD/mediaChuquis/turismo/<?php echo $turismoFoto; ?>" alt="">
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="turismo_wallpaper"><i class="fas fa-video"></i> VIDEO WALLPAPER</label>
            <input  class="configuracion-file" type="file" name="turismo_wallpaper" accept="video/*" id="turismo_wallpaper">
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