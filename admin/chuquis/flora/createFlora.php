<?php

$errores = [];

$floraNombre  = '';
$floraTexto = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){



    $floraNombre = mysqli_escape_string($cnx, trim($_POST['flora_nombre'])); 
    $floraTexto = mysqli_escape_string($cnx, trim($_POST['flora_texto'])); 
    $floraFoto = $_FILES['flora_foto'];

   
    // var_dump($user_foto);
    // exit;
    if(!$floraNombre){
        $errores['nombreVacio'] = 'El nombre no debe estar Vacio';
    }

    if(strlen($floraNombre) > 50){
        $errores['nombreLargo'] = 'Nombre demasiado Largo max 50';
    }

    if(!$floraTexto){
        $errores['textoVacio'] = 'El texto no debe estar vacio';
    }

 

    

  
    if($floraFoto['size'] > 5000000){
        $errores['fotoPesado'] = 'Imagen Muy pesado, menos de 5MB';
    }



    if( $floraFoto['type'] !== 'image/jpeg' && $floraFoto['type'] !== 'image/jpg' && $floraFoto['type'] !== 'image/png' && $floraFoto['type'] !== 'image/webp'){
        $errores['fotoNoDisponible'] = 'Insertar Imagen obligatoriamente en formato imagen';
    }

    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $floraImagenes   = '/flora/';

        // crear carpeta si no exister
        if(!is_dir($carpetaMediaBD.$floraImagenes)){
            mkdir($carpetaMediaBD.$floraImagenes);
        }

        $nombreImagen = md5( uniqid( rand(), true)).".jpg";
        move_uploaded_file($floraFoto['tmp_name'], $carpetaMediaBD.$floraImagenes.$nombreImagen); 


        $chuquisCod = 'CHU-FLO';
        $codigoFlora = date('Y'.'m'.'d'.'s');
        $fechaFlora = date('Y/m/d');

        $addFlora  = mysqli_query($cnx, "INSERT INTO flora (flora_cod, flora_nombre, flora_texto, flora_foto,flora_fecha, flora_ChuquisCod) VALUES ('$codigoFlora','$floraNombre','$floraTexto', '$nombreImagen','$fechaFlora', '$chuquisCod')");
      
        
        if($addFlora){
            header('Location: index.php?action=createFlora&agregado=1');
        }
    }   
    
}

?>

<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Flora</h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="flora_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $floraNombre; ?>" name="flora_nombre" placeholder="Titulo">
            <?php if(isset($errores['nombreVacio'])):?>
                <span class="error-process"><?php echo $errores['nombreVacio']; ?></span>
            <?php endif; ?>
            <?php if(isset($errores['nombreLargo'])):?>
                <span class="error-process"><?php echo $errores['nombreLargo']; ?></span>
            <?php endif; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="flora_texto">Texto de la imagen</label>
            <textarea class="configuracion-input" name="flora_texto"><?php echo $floraTexto; ?></textarea>
            <?php if(isset($errores['textoVacio'])):?>
                <span class="error-process"><?php echo $errores['textoVacio']; ?></span>
            <?php endif; ?>
        </div>
        <div class="configuracion-inp-foto">
            <label class="configuracion-lbl-file"  for="flora_foto">Imagen</label>
            <input  class="configuracion-file" type="file" name="flora_foto" accept="image/*" id="flora_foto" >
            <?php if(isset($errores['fotoNoDisponible'])): ?>
                <span class="error-process"><?php echo $errores['fotoNoDisponible']; ?></span>
            <?php  endif;?>
            <?php if(isset($errores['fotoPesado'])): ?>
                <span class="error-process"><?php echo $errores['fotoPesado']; ?></span>
            <?php  endif;?>
        </div>
        <input class="configuracion-submit" type="submit" value="Agregar">

        <?php
            $actualizadoCorrectamente = $_GET['agregado']  ?? null;
            if($actualizadoCorrectamente == 1 && empty($errores)):
         ?>
         <span class="success-process">Agregado Correctamente <a href="index.php?action=readFlora">Ver Agregado</a> </span>
         <?php endif; ?>
    </form>
</section>