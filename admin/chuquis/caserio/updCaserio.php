<?php

$errores = [];

$queryCaserio = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'CHU-CAS'");
$resultadoQuery = mysqli_fetch_assoc($queryCaserio);

$caserioFoto = $resultadoQuery['chuquis_foto'];
$caserioVideo = $resultadoQuery['chuquis_video'];
$caserioTexto = $resultadoQuery['chuquis_texto'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $caserio_welcome =    $_FILES['caserio_welcome'];
    $caserio_wallpaper =    $_FILES['caserio_wallpaper'];
    $caserio_texto =    $_POST['caserio_texto'];
  
    $errores = validarFormularioWelcome($errores,$caserio_welcome, $caserio_wallpaper, $caserio_texto);
    
    if(empty($errores)){
        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $mediacaserio = '/chuquis/';

        //crear carpeta si no exister
        if(!is_dir($carpetaMediaBD.$mediacaserio)){
            mkdir($carpetaMediaBD.$mediacaserio);
        }

        //actualizar foto welcome
        $nombreImagen = '';
        // si pone una imagen el usuario
        if($caserio_welcome['name']){
            unlink($carpetaMediaBD.$mediacaserio.$caserioFoto);

            //hasheeamos el nombre de la imagen
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
    
            move_uploaded_file($caserio_welcome['tmp_name'], $carpetaMediaBD.$mediacaserio.$nombreImagen);     
        }else{
            $nombreImagen = $caserioFoto;
        }

        //actualizar video Wallpaper
        $nombreVideo = '';
        // si pone una video  el usuario
        if($caserio_wallpaper['name']){
                unlink($carpetaMediaBD.$mediacaserio.$caserioVideo);

                //hasheeamos el nombre de la imagen
                $nombreVideo = md5( uniqid( rand(), true)).".mp4";
    
                move_uploaded_file($caserio_wallpaper['tmp_name'], $carpetaMediaBD.$mediacaserio.$nombreVideo);     
        }else{
            $nombreVideo = $caserioVideo;
        }
      
        $updatecaserio = mysqli_query($cnx, "UPDATE chuquis SET chuquis_texto = '$caserio_texto',  chuquis_foto = '$nombreImagen', chuquis_video = '$nombreVideo' WHERE chuquis_cod = 'CHU-CAS'"); 

        if($updatecaserio){
            header('Location: index.php?action=updCaserio&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">

    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title"> Cambiar Welcome & Wallpaper Caserio</h2>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="caserio_welcome"><i class="fas fa-image"></i> Foto Welcome</label>
            <input  class="configuracion-file" type="file" accept="image/*" name="caserio_welcome" id="caserio_welcome">
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : ''; ?>
            <img width="100px" src="./mediaBD/mediaChuquis/chuquis/<?php echo $caserioFoto; ?>" alt="">
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="caserio_wallpaper"><i class="fas fa-video"></i> VIDEO WALLPAPER</label>
            <input  class="configuracion-file" type="file" name="caserio_wallpaper" accept="video/*" id="caserio_wallpaper">
            <span>VIdeo MAXIMO de 40MB</span>
            <?php echo isset($errores['videoNoDisponible']) ? "<span class='error-process'>$errores[videoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['videoPesado']) ? "<span class='error-process'>$errores[videoPesado]</span>" : '' ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl" for="caserio_texto"> Texto de Caserio</label>
            <textarea name="caserio_texto" id="" cols="20" rows="5"><?php echo $caserioTexto; ?></textarea>
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