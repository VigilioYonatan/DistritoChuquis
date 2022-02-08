<?php

$errores = [];

$queryFlora = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'CHU-FLO'");
$resultadoQuery = mysqli_fetch_assoc($queryFlora);

$floraFoto = $resultadoQuery['chuquis_foto'];
$floraVideo = $resultadoQuery['chuquis_video'];
$floraTexto= $resultadoQuery['chuquis_texto'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $flora_welcome =    $_FILES['flora_welcome'];
    $flora_wallpaper =    $_FILES['flora_wallpaper'];
    $flora_texto =    $_POST['flora_texto'];
  
    $errores = validarFormularioWelcome($errores,$flora_welcome, $flora_wallpaper, $flora_texto );
    
    if(empty($errores)){
        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $mediaflora = '/chuquis/';

        //crear carpeta si no exister
        if(!is_dir($carpetaMediaBD.$mediaflora)){
            mkdir($carpetaMediaBD.$mediaflora);
        }

        //actualizar foto welcome
        $nombreImagen = '';
        // si pone una imagen el usuario
        if($flora_welcome['name']){
            unlink($carpetaMediaBD.$mediaflora.$floraFoto);

            //hasheeamos el nombre de la imagen
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
    
            move_uploaded_file($flora_welcome['tmp_name'], $carpetaMediaBD.$mediaflora.$nombreImagen);     
        }else{
            $nombreImagen = $floraFoto;
        }

        //actualizar video Wallpaper
        $nombreVideo = '';
        // si pone una video  el usuario
        if($flora_wallpaper['name']){
                unlink($carpetaMediaBD.$mediaflora.$floraVideo);

                //hasheeamos el nombre de la imagen
                $nombreVideo = md5( uniqid( rand(), true)).".mp4";
    
                move_uploaded_file($flora_wallpaper['tmp_name'], $carpetaMediaBD.$mediaflora.$nombreVideo);     
        }else{
            $nombreVideo = $floraVideo;
        }
      
        $updateflora = mysqli_query($cnx, "UPDATE chuquis SET chuquis_texto = '$flora_texto', chuquis_foto = '$nombreImagen', chuquis_video = '$nombreVideo' WHERE chuquis_cod = 'CHU-FLO'"); 

        if($updateflora){
            header('Location: index.php?action=updFlora&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">

    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title"> Cambiar Welcome & Wallpaper Flora</h2>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="flora_welcome"><i class="fas fa-image"></i> Foto Welcome</label>
            <input  class="configuracion-file" type="file" accept="image/*" name="flora_welcome" id="flora_welcome">
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : ''; ?>
            <img width="100px" src="./mediaBD/mediaChuquis/chuquis/<?php echo $floraFoto; ?>" alt="">
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="flora_wallpaper"><i class="fas fa-video"></i> VIDEO WALLPAPER</label>
            <input  class="configuracion-file" type="file" name="flora_wallpaper" accept="video/*" id="flora_wallpaper">
            <span>VIdeo MAXIMO de 40MB</span>
            <?php echo isset($errores['videoNoDisponible']) ? "<span class='error-process'>$errores[videoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['videoPesado']) ? "<span class='error-process'>$errores[videoPesado]</span>" : '' ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl" for="flora_texto"> Texto de Flora</label>
            <textarea name="flora_texto" id="" cols="20" rows="5"><?php echo $floraTexto; ?></textarea>
            <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : '' ?>
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