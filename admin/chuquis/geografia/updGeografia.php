<?php

$errores = [];

$queryGeografia = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'CHU-GEO'");
$resultadoQuery = mysqli_fetch_assoc($queryGeografia);

$geografiaFoto = $resultadoQuery['chuquis_foto'];
$geografiaVideo = $resultadoQuery['chuquis_video'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $geografia_welcome =    $_FILES['geografia_welcome'];
    $geografia_wallpaper =    $_FILES['geografia_wallpaper'];
  
    $errores = validarFormularioWelcome($errores,$geografia_welcome, $geografia_wallpaper );
    
    if(empty($errores)){
        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $mediageografia = '/geografia/';

        //crear carpeta si no exister
        if(!is_dir($carpetaMediaBD.$mediageografia)){
            mkdir($carpetaMediaBD.$mediageografia);
        }

        //actualizar foto welcome
        $nombreImagen = '';
        // si pone una imagen el usuario
        if($geografia_welcome['name']){
            unlink($carpetaMediaBD.$mediageografia.$geografiaFoto);

            //hasheeamos el nombre de la imagen
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
    
            move_uploaded_file($geografia_welcome['tmp_name'], $carpetaMediaBD.$mediageografia.$nombreImagen);     
        }else{
            $nombreImagen = $geografiaFoto;
        }

        //actualizar video Wallpaper
        $nombreVideo = '';
        // si pone una video  el usuario
        if($geografia_wallpaper['name']){
                unlink($carpetaMediaBD.$mediageografia.$geografiaVideo);

                //hasheeamos el nombre de la imagen
                $nombreVideo = md5( uniqid( rand(), true)).".mp4";
    
                move_uploaded_file($geografia_wallpaper['tmp_name'], $carpetaMediaBD.$mediageografia.$nombreVideo);     
        }else{
            $nombreVideo = $geografiaVideo;
        }
      
        $updategeografia = mysqli_query($cnx, "UPDATE chuquis SET chuquis_foto = '$nombreImagen', chuquis_video = '$nombreVideo' WHERE chuquis_cod = 'CHU-GEO'"); 

        if($updategeografia){
            header('Location: index.php?action=updGeografia&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">

    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title"> Cambiar Welcome & Wallpaper Geografia</h2>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="geografia_welcome"><i class="fas fa-image"></i> Foto Welcome</label>
            <input  class="configuracion-file" type="file" accept="image/*" name="geografia_welcome" id="geografia_welcome">
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : ''; ?>
            <img width="100px" src="./mediaBD/mediaChuquis/geografia/<?php echo $geografiaFoto; ?>" alt="">
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="geografia_wallpaper"><i class="fas fa-video"></i> VIDEO WALLPAPER</label>
            <input  class="configuracion-file" type="file" name="geografia_wallpaper" accept="video/*" id="geografia_wallpaper">
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