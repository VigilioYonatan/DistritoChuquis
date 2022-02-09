<?php

$errores = [];

$queryLugaresturisticos = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'TINGO'");
$resultadoQuery = mysqli_fetch_assoc($queryLugaresturisticos);

$lugaresturisticosFoto = $resultadoQuery['chuquis_foto'];
$lugaresturisticosVideo = $resultadoQuery['chuquis_video'];
$lugaresturisticosTexto = $resultadoQuery['chuquis_texto'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $lugaresturisticos_welcome =    $_FILES['lugaresturisticos_welcome'];
    $lugaresturisticos_wallpaper =    $_FILES['lugaresturisticos_wallpaper'];
    $lugaresturisticos_texto =    $_POST['lugaresturisticos_texto'];
  
    $errores = validarFormularioWelcome($errores,$lugaresturisticos_welcome, $lugaresturisticos_wallpaper,$lugaresturisticos_texto );
    
    if(empty($errores)){
        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $medialugaresturisticos = '/chuquis/';

        //crear carpeta si no exister
        if(!is_dir($carpetaMediaBD.$medialugaresturisticos)){
            mkdir($carpetaMediaBD.$medialugaresturisticos);
        }

        //actualizar foto welcome
        $nombreImagen = '';
        // si pone una imagen el usuario
        if($lugaresturisticos_welcome['name']){
            unlink($carpetaMediaBD.$medialugaresturisticos.$lugaresturisticosFoto);

            //hasheeamos el nombre de la imagen
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
    
            move_uploaded_file($lugaresturisticos_welcome['tmp_name'], $carpetaMediaBD.$medialugaresturisticos.$nombreImagen);     
        }else{
            $nombreImagen = $lugaresturisticosFoto;
        }

        //actualizar video Wallpaper
        $nombreVideo = '';
        // si pone una video  el usuario
        if($lugaresturisticos_wallpaper['name']){
                unlink($carpetaMediaBD.$medialugaresturisticos.$lugaresturisticosVideo);

                //hasheeamos el nombre de la imagen
                $nombreVideo = md5( uniqid( rand(), true)).".mp4";
    
                move_uploaded_file($lugaresturisticos_wallpaper['tmp_name'], $carpetaMediaBD.$medialugaresturisticos.$nombreVideo);     
        }else{
            $nombreVideo = $lugaresturisticosVideo;
        }
      
        $updatelugaresturisticos = mysqli_query($cnx, "UPDATE chuquis SET chuquis_texto ='$lugaresturisticos_texto', chuquis_foto = '$nombreImagen', chuquis_video = '$nombreVideo' WHERE chuquis_cod = 'TINGO'"); 

        if($updatelugaresturisticos){
            header('Location: index.php?action=updLugaresTuristicos&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">

    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title"> Cambiar Welcome & Wallpaper Lugares turisticos</h2>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="lugaresturisticos_welcome"><i class="fas fa-image"></i> Foto Welcome</label>
            <input  class="configuracion-file" type="file" accept="image/*" name="lugaresturisticos_welcome" id="lugaresturisticos_welcome">
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : ''; ?>
            <img width="100px" src="./mediaBD/mediaChuquis/chuquis/<?php echo $lugaresturisticosFoto; ?>" alt="">
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="lugaresturisticos_wallpaper"><i class="fas fa-video"></i> VIDEO WALLPAPER</label>
            <input  class="configuracion-file" type="file" name="lugaresturisticos_wallpaper" accept="video/*" id="lugaresturisticos_wallpaper">
            <span>VIdeo MAXIMO de 40MB</span>
            <?php echo isset($errores['videoNoDisponible']) ? "<span class='error-process'>$errores[videoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['videoPesado']) ? "<span class='error-process'>$errores[videoPesado]</span>" : '' ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl" for="lugaresturisticos_texto"> Texto de Lugaresturisticos</label>
            <textarea name="lugaresturisticos_texto" id="" cols="20" rows="5"><?php echo $lugaresturisticosTexto; ?></textarea>
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