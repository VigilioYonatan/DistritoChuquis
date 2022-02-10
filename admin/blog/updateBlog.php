<?php

$blogCod = $_GET['blogCod'];
$errores = [];


$queryblog = mysqli_query($cnx, "SELECT * FROM chuquis_tables WHERE cod = '$blogCod'");
$resultadoQuery = mysqli_fetch_assoc($queryblog);

$blogNombre    = $resultadoQuery['nombre'];
$blogTexto     = $resultadoQuery['texto'];
$blogFoto      = $resultadoQuery['foto'];
$blogFecha     = $resultadoQuery['fecha'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $blog_Nombre = mysqli_escape_string($cnx, trim($_POST['blog_nombre'])); 
    $blog_Texto = mysqli_escape_string($cnx, trim($_POST['blog_texto'])); 
    $blog_Foto = $_FILES['blog_foto'];

    // validar formulario
    $errores = validarFormulario($errores,$blog_Nombre , $blog_Texto, $blog_Foto, true);
    
   
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/';
        $blogImagenes   = '/mediaBlog/';

        $nombreImagen = '';

        if($blog_Foto['name']){
            unlink($carpetaMediaBD.$blogImagenes.$blogFoto );
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
            move_uploaded_file($blog_Foto['tmp_name'], $carpetaMediaBD.$blogImagenes.$nombreImagen); 
        }else{
            $nombreImagen = $blogFoto ;
        }


        $updblog  = mysqli_query($cnx, "UPDATE chuquis_tables SET nombre = '$blog_Nombre', texto ='$blog_Texto', foto = '$nombreImagen' WHERE cod = '$blogCod'");
      
        
        if($updblog){
            header('Location: index.php?action=readBlog&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Editar Blog de <?php echo $blogCod; ?></h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="blog_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $blogNombre; ?>" name="blog_nombre" placeholder="Titulo">
                <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : '' ?>
                <?php echo isset($errores['nombreLargo']) ? "<span class='error-process'>$errores[nombreLargo]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="blog_texto">Texto de la imagen</label>
            <textarea class="configuracion-textArea" name="blog_texto"><?php echo $blogTexto; ?></textarea>
                <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : '';?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="blog_foto"><i class="fas fa-image"></i> Imagen</label>
            <input  class="configuracion-file" accept="image/*" type="file" name="blog_foto" id="blog_foto" >
            <img width="200px" src="./mediaBD/mediaChuquis/blog/<?php echo $blogFoto; ?>" alt="">
            
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : '';?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : '';?>
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