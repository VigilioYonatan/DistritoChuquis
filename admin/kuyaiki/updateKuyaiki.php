<?php

$kuyaikiCod = $_GET['kuyaikiCod'];
$errores = [];


$querykuyaiki = mysqli_query($cnx, "SELECT * FROM chuquis_tables WHERE cod = '$kuyaikiCod'");
$resultadoQuery = mysqli_fetch_assoc($querykuyaiki);

$kuyaikiNombre    = $resultadoQuery['nombre'];
$kuyaikiTexto     = $resultadoQuery['texto'];
$kuyaikiFoto      = $resultadoQuery['foto'];
$kuyaikiFecha     = $resultadoQuery['fecha'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $kuyaiki_Nombre = mysqli_escape_string($cnx, trim($_POST['kuyaiki_nombre'])); 
    $kuyaiki_Texto = mysqli_escape_string($cnx, trim($_POST['kuyaiki_texto'])); 
    $kuyaiki_Foto = $_FILES['kuyaiki_foto'];

    // validar formulario
    $errores = validarFormulario($errores,$kuyaiki_Nombre , $kuyaiki_Texto, $kuyaiki_Foto, true);
    
   
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/';
        $kuyaikiImagenes   = '/mediaKuyaiki/';

        $nombreImagen = '';

        if($kuyaiki_Foto['name']){
            unlink($carpetaMediaBD.$kuyaikiImagenes.$kuyaikiFoto );
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
            move_uploaded_file($kuyaiki_Foto['tmp_name'], $carpetaMediaBD.$kuyaikiImagenes.$nombreImagen); 
        }else{
            $nombreImagen = $kuyaikiFoto ;
        }


        $updkuyaiki  = mysqli_query($cnx, "UPDATE chuquis_tables SET nombre = '$kuyaiki_Nombre', texto ='$kuyaiki_Texto', foto = '$nombreImagen' WHERE cod = '$kuyaikiCod'");
      
        
        if($updkuyaiki){
            header('Location: index.php?action=readKuyaiki&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Editar Kuyaiki de <?php echo $kuyaikiCod; ?></h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="kuyaiki_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $kuyaikiNombre; ?>" name="kuyaiki_nombre" placeholder="Titulo">
                <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : '' ?>
                <?php echo isset($errores['nombreLargo']) ? "<span class='error-process'>$errores[nombreLargo]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="kuyaiki_texto">Texto de la imagen</label>
            <textarea class="configuracion-textArea" name="kuyaiki_texto"><?php echo $kuyaikiTexto; ?></textarea>
                <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : '';?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="kuyaiki_foto"><i class="fas fa-image"></i> Imagen</label>
            <input  class="configuracion-file" accept="image/*" type="file" name="kuyaiki_foto" id="kuyaiki_foto" >
            <img width="200px" src="./mediaBD/mediaChuquis/kuyaiki/<?php echo $kuyaikiFoto; ?>" alt="">
            
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