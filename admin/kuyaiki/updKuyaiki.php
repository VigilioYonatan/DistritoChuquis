<?php

$errores = [];

$queryKuyaiki = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'KUYAIKI'");
$resultadoQuery = mysqli_fetch_assoc($queryKuyaiki);

$kuyaikiFoto = $resultadoQuery['chuquis_foto'];
$kuyaikiWallpaper = $resultadoQuery['chuquis_video'];
$kuyaikiTexto= $resultadoQuery['chuquis_texto'];
$kuyaikiNombre= $resultadoQuery['chuquis_nombre'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){


    $kuyaiki_wallpaper =    $_FILES['kuyaiki_wallpaper'];
    $kuyaiki_texto =    mysqli_escape_string($cnx, $_POST['kuyaiki_texto']);
    $kuyaiki_nombre =    mysqli_escape_string($cnx, $_POST['kuyaiki_nombre']); 

    if($kuyaiki_wallpaper['size'] > 40000000){
        $errores['videoPesado'] = 'Video muy pesado, max de 40MB';
    }

    if(!$kuyaiki_texto){
        $errores['textoVacio'] = 'Texto vacio, llenarlo';
    }

    
    if(empty($errores)){
        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $mediakuyaiki = '/chuquis/';

        //crear carpeta si no exister
        if(!is_dir($carpetaMediaBD.$mediakuyaiki)){
            mkdir($carpetaMediaBD.$mediakuyaiki);
        }


        //actualizar video Wallpaper
        $nombreVideo = '';
        // si pone una video  el usuario
        if($kuyaiki_wallpaper['name']){
                unlink($carpetaMediaBD.$mediakuyaiki.$kuyaikiWallpaper);

                //hasheeamos el nombre de la imagen
                $nombreVideo = md5( uniqid( rand(), true)).".mp4";
    
                move_uploaded_file($kuyaiki_wallpaper['tmp_name'], $carpetaMediaBD.$mediakuyaiki.$nombreVideo);     
        }else{
            $nombreVideo = $kuyaikiWallpaper;
        }
      
        $updatekuyaiki = mysqli_query($cnx, "UPDATE chuquis SET chuquis_nombre = '$kuyaiki_nombre', chuquis_texto = '$kuyaiki_texto',  chuquis_video = '$nombreVideo' WHERE chuquis_cod = 'KUYAIKI'"); 
  
        if($updatekuyaiki){
            header('Location: index.php?action=updKuyaiki&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">

    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title"> Cambiar titulo & Wallpaper Kuyaiki</h2>

        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="kuyaiki_wallpaper"><i class="fas fa-video"></i> Video WALLPAPER</label>
            <input  class="configuracion-file" type="file" name="kuyaiki_wallpaper" accept="video/*" id="kuyaiki_wallpaper">
            <?php echo isset($errores['videoPesado']) ? "<span class='error-process'>$errores[videoPesado]</span>" : '' ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl" for="kuyaiki_nombre"> titulo de Kuyaiki</label>
            <input class="configuracion-input" type="text" value="<?php echo $kuyaikiNombre; ?>" name="kuyaiki_nombre" placeholder="Titulo">
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl" for="kuyaiki_texto"> Texto de Kuyaiki</label>
            <textarea name="kuyaiki_texto" id="" cols="20" rows="5"><?php echo $kuyaikiTexto; ?></textarea>
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