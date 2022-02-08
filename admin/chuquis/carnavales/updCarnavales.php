<?php

$errores = [];

$queryCarnavales = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'CHU-CAR'");
$resultadoQuery = mysqli_fetch_assoc($queryCarnavales);

$carnavalesFoto = $resultadoQuery['chuquis_foto'];
$carnavalesVideo = $resultadoQuery['chuquis_video'];
$carnavalesTexto = $resultadoQuery['chuquis_texto'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $carnavales_welcome =    $_FILES['carnavales_welcome'];
    $carnavales_wallpaper =    $_FILES['carnavales_wallpaper'];
    $carnavales_texto =    $_POST['carnavales_texto'];
  
    $errores = validarFormularioWelcome($errores,$carnavales_welcome, $carnavales_wallpaper,$carnavales_texto );
    
    if(empty($errores)){
        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $mediacarnavales = '/chuquis/';

        //crear carpeta si no exister
        if(!is_dir($carpetaMediaBD.$mediacarnavales)){
            mkdir($carpetaMediaBD.$mediacarnavales);
        }

        //actualizar foto welcome
        $nombreImagen = '';
        // si pone una imagen el usuario
        if($carnavales_welcome['name']){
            unlink($carpetaMediaBD.$mediacarnavales.$carnavalesFoto);

            //hasheeamos el nombre de la imagen
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
    
            move_uploaded_file($carnavales_welcome['tmp_name'], $carpetaMediaBD.$mediacarnavales.$nombreImagen);     
        }else{
            $nombreImagen = $carnavalesFoto;
        }

        //actualizar video Wallpaper
        $nombreVideo = '';
        // si pone una video  el usuario
        if($carnavales_wallpaper['name']){
                unlink($carpetaMediaBD.$mediacarnavales.$carnavalesVideo);

                //hasheeamos el nombre de la imagen
                $nombreVideo = md5( uniqid( rand(), true)).".mp4";
    
                move_uploaded_file($carnavales_wallpaper['tmp_name'], $carpetaMediaBD.$mediacarnavales.$nombreVideo);     
        }else{
            $nombreVideo = $carnavalesVideo;
        }
      
        $updatecarnavales = mysqli_query($cnx, "UPDATE chuquis SET chuquis_texto ='$carnavales_texto', chuquis_foto = '$nombreImagen', chuquis_video = '$nombreVideo' WHERE chuquis_cod = 'CHU-CAR'"); 

        if($updatecarnavales){
            header('Location: index.php?action=updCarnavales&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">

    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title"> Cambiar Welcome & Wallpaper Carnavales</h2>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="carnavales_welcome"><i class="fas fa-image"></i> Foto Welcome</label>
            <input  class="configuracion-file" type="file" accept="image/*" name="carnavales_welcome" id="carnavales_welcome">
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : ''; ?>
            <img width="100px" src="./mediaBD/mediaChuquis/chuquis/<?php echo $carnavalesFoto; ?>" alt="">
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="carnavales_wallpaper"><i class="fas fa-video"></i> VIDEO WALLPAPER</label>
            <input  class="configuracion-file" type="file" name="carnavales_wallpaper" accept="video/*" id="carnavales_wallpaper">
            <span>VIdeo MAXIMO de 40MB</span>
            <?php echo isset($errores['videoNoDisponible']) ? "<span class='error-process'>$errores[videoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['videoPesado']) ? "<span class='error-process'>$errores[videoPesado]</span>" : '' ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl" for="carnavales_texto"> Texto de Carnavales</label>
            <textarea name="carnavales_texto" id="" cols="20" rows="5"><?php echo $carnavalesTexto; ?></textarea>
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