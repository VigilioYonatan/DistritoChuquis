<?php

$errores = [];

$queryCostumbres = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'CHU-COS'");
$resultadoQuery = mysqli_fetch_assoc($queryCostumbres);

$costumbresFoto = $resultadoQuery['chuquis_foto'];
$costumbresVideo = $resultadoQuery['chuquis_video'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $costumbres_welcome =    $_FILES['costumbres_welcome'];
    $costumbres_wallpaper =    $_FILES['costumbres_wallpaper'];
  
    $errores = validarFormularioWelcome($errores,$costumbres_welcome, $costumbres_wallpaper );
    
    if(empty($errores)){
        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $mediacostumbres = '/chuquis/';

        //crear carpeta si no exister
        if(!is_dir($carpetaMediaBD.$mediacostumbres)){
            mkdir($carpetaMediaBD.$mediacostumbres);
        }

        //actualizar foto welcome
        $nombreImagen = '';
        // si pone una imagen el usuario
        if($costumbres_welcome['name']){
            unlink($carpetaMediaBD.$mediacostumbres.$costumbresFoto);

            //hasheeamos el nombre de la imagen
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
    
            move_uploaded_file($costumbres_welcome['tmp_name'], $carpetaMediaBD.$mediacostumbres.$nombreImagen);     
        }else{
            $nombreImagen = $costumbresFoto;
        }

        //actualizar video Wallpaper
        $nombreVideo = '';
        // si pone una video  el usuario
        if($costumbres_wallpaper['name']){
                unlink($carpetaMediaBD.$mediacostumbres.$costumbresVideo);

                //hasheeamos el nombre de la imagen
                $nombreVideo = md5( uniqid( rand(), true)).".mp4";
    
                move_uploaded_file($costumbres_wallpaper['tmp_name'], $carpetaMediaBD.$mediacostumbres.$nombreVideo);     
        }else{
            $nombreVideo = $costumbresVideo;
        }
      
        $updatecostumbres = mysqli_query($cnx, "UPDATE chuquis SET chuquis_foto = '$nombreImagen', chuquis_video = '$nombreVideo' WHERE chuquis_cod = 'CHU-COS'"); 

        if($updatecostumbres){
            header('Location: index.php?action=updCostumbres&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">

    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title"> Cambiar Welcome & Wallpaper Costumbres</h2>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="costumbres_welcome"><i class="fas fa-image"></i> Foto Welcome</label>
            <input  class="configuracion-file" type="file" accept="image/*" name="costumbres_welcome" id="costumbres_welcome">
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : ''; ?>
            <img width="100px" src="./mediaBD/mediaChuquis/chuquis/<?php echo $costumbresFoto; ?>" alt="">
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="costumbres_wallpaper"><i class="fas fa-video"></i> VIDEO WALLPAPER</label>
            <input  class="configuracion-file" type="file" name="costumbres_wallpaper" accept="video/*" id="costumbres_wallpaper">
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