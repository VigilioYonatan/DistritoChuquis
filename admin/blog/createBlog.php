<?php


$errores = [];

$blogNombre  = '';
$blogTexto = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $blogNombre = mysqli_escape_string($cnx, trim($_POST['blog_nombre']));
    $blogTexto = mysqli_escape_string($cnx, trim($_POST['blog_texto']));
    $blogFoto = $_FILES['blog_foto'];

    //validar Formulario
    $errores = validarFormulario($errores,$blogNombre, $blogTexto, $blogFoto, $upd = false);

    // si ya no hay errores
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/';
        $blogImagenes   = '/mediaBlog/';

        // crear carpeta si no existe
        if(!is_dir($carpetaMediaBD.$blogImagenes)){
            mkdir($carpetaMediaBD.$blogImagenes);
        }

        $nombreImagen = md5( uniqid( rand(), true)).".jpg";
        move_uploaded_file($blogFoto['tmp_name'], $carpetaMediaBD.$blogImagenes.$nombreImagen); 


        $chuquisCod = 'BLOG';
        $codigoBlog = strtotime(date('c')).date('ymd'); // codigo generador
        $fechaBlog = date('Y/m/d');
        $ruta = 'mediaBlog';

        $addBlog  = mysqli_query($cnx, "INSERT INTO chuquis_tables (cod, nombre, texto, foto, fecha, ChuquisCod, ruta) VALUES ('$codigoBlog','$blogNombre','$blogTexto', '$nombreImagen','$fechaBlog', '$chuquisCod','$ruta')");

        if($addBlog){
            header('Location: index.php?action=createBlog&agregado=1');
        }
    }   
    
}

?>
<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Blog</h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="blog_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $blogNombre; ?>" name="blog_nombre" placeholder="Titulo">
            <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : ''; ?>
            <?php echo isset($errores['nombreLargo']) ? "<span class=error-process'>$errores[nombreLargo]></span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="blog_texto">Texto de la imagen</label>
            <textarea class="configuracion-input" name="blog_texto"><?php echo $blogTexto; ?></textarea>
            <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp-foto">
            <label class="configuracion-lbl-file"  for="blog_foto">Imagen</label>
            <input  class="configuracion-file" type="file" name="blog_foto" accept="image/*" id="blog_foto" >
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : ''; ?>
        </div>
        <input class="configuracion-submit" type="submit" value="Agregar">

        <?php
            $actualizadoCorrectamente = $_GET['agregado']  ?? null;
            if($actualizadoCorrectamente == 1 && empty($errores)):
         ?>
         <span class="success-process">Agregado Correctamente <a href="index.php?action=readBlog">Ver Agregado</a> </span>
         <?php endif; ?>
    </form>
</section>