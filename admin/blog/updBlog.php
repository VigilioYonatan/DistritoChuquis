<?php

$errores = [];

$queryBlog = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'BLOG'");
$resultadoQuery = mysqli_fetch_assoc($queryBlog);

$blogFoto = $resultadoQuery['chuquis_foto'];
$blogWallpaper = $resultadoQuery['chuquis_video'];
$blogTexto= $resultadoQuery['chuquis_texto'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $blog_welcome =    $_FILES['blog_welcome'];
    $blog_wallpaper =    $_FILES['blog_wallpaper'];
    $blog_texto =    $_POST['blog_texto'];
  
    
    if(empty($errores)){
        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $mediablog = '/chuquis/';

        //crear carpeta si no exister
        if(!is_dir($carpetaMediaBD.$mediablog)){
            mkdir($carpetaMediaBD.$mediablog);
        }

        //actualizar foto welcome
        $nombreImagen = '';
        // si pone una imagen el usuario
        if($blog_welcome['name']){
            unlink($carpetaMediaBD.$mediablog.$blogFoto);

            //hasheeamos el nombre de la imagen
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
    
            move_uploaded_file($blog_welcome['tmp_name'], $carpetaMediaBD.$mediablog.$nombreImagen);     
        }else{
            $nombreImagen = $blogFoto;
        }

        //actualizar video Wallpaper
        $nombreVideo = '';
        // si pone una video  el usuario
        if($blog_wallpaper['name']){
                unlink($carpetaMediaBD.$mediablog.$blogWallpaper);

                //hasheeamos el nombre de la imagen
                $nombreVideo = md5( uniqid( rand(), true)).".mp4";
    
                move_uploaded_file($blog_wallpaper['tmp_name'], $carpetaMediaBD.$mediablog.$nombreVideo);     
        }else{
            $nombreVideo = $blogWallpaper;
        }
      
        $updateblog = mysqli_query($cnx, "UPDATE chuquis SET chuquis_texto = '$blog_texto', chuquis_foto = '$nombreImagen', chuquis_video = '$nombreVideo' WHERE chuquis_cod = 'BLOG'"); 

        if($updateblog){
            header('Location: index.php?action=updBlog&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">

    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title"> Cambiar Welcome & Wallpaper Blog</h2>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="blog_welcome"><i class="fas fa-image"></i> Foto Welcome</label>
            <input  class="configuracion-file" type="file" accept="image/*" name="blog_welcome" id="blog_welcome">
            <img width="100px" src="./mediaBD/mediaChuquis/chuquis/<?php echo $blogFoto; ?>" alt="">
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="blog_wallpaper"><i class="fas fa-image"></i> imagen WALLPAPER</label>
            <input  class="configuracion-file" type="file" name="blog_wallpaper" accept="imagen/*" id="blog_wallpaper">
            <img width="200px" src="./mediaBD/mediaChuquis/chuquis/<?php echo $blogWallpaper; ?>" alt="">

        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl" for="blog_texto"> Texto de Blog</label>
            <textarea name="blog_texto" id="" cols="20" rows="5"><?php echo $blogTexto; ?></textarea>
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