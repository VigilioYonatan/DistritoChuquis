<?php

$errores = [];

$costumbreNombre  = '';
$costumbreTexto = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){



    $costumbreNombre = mysqli_escape_string($cnx, trim($_POST['costumbre_nombre'])); 
    $costumbreTexto = mysqli_escape_string($cnx, trim($_POST['costumbre_texto'])); 
    $costumbreFoto = $_FILES['costumbre_foto'];

   
    // var_dump($user_foto);
    // exit;
    if(!$costumbreNombre){
        $errores['nombreVacio'] = 'El nombre no debe estar Vacio';
    }

    if(strlen($costumbreNombre) > 50){
        $errores['nombreLargo'] = 'Nombre demasiado Largo max 50';
    }

    if(!$costumbreTexto){
        $errores['textoVacio'] = 'El texto no debe estar vacio';
    }

 

    

  
    if($costumbreFoto['size'] > 5000000){
        $errores['fotoPesado'] = 'Imagen Muy pesado, menos de 5MB';
    }



    if( $costumbreFoto['type'] !== 'image/jpeg' && $costumbreFoto['type'] !== 'image/jpg' && $costumbreFoto['type'] !== 'image/png' && $costumbreFoto['type'] !== 'image/webp'){
        $errores['fotoNoDisponible'] = 'Insertar Imagen obligatoriamente en formato imagen';
    }

    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $costumbresImagenes   = '/costumbres/';

        // crear carpeta si no exister
        if(!is_dir($carpetaMediaBD.$costumbresImagenes)){
            mkdir($carpetaMediaBD.$costumbresImagenes);
        }

        $nombreImagen = md5( uniqid( rand(), true)).".jpg";
        move_uploaded_file($costumbreFoto['tmp_name'], $carpetaMediaBD.$costumbresImagenes.$nombreImagen); 


        $chuquisCod = 'CHU-COS';
        $codigoCostumbre = date('Y'.'m'.'d'.'s');
        $fechaCostumbre = date('Y/m/d');

        $addCostumbre  = mysqli_query($cnx, "INSERT INTO costumbre (costumbre_cod, costumbre_nombre, costumbre_texto, costumbre_foto,costumbre_fecha, costumbre_ChuquisCod) VALUES ('$codigoCostumbre','$costumbreNombre','$costumbreTexto', '$nombreImagen','$fechaCostumbre', '$chuquisCod')"); //$userCod hereda de index.php
      
        
        if($addCostumbre){
            header('Location: index.php?action=createCostumbres&agregado=1');
        }
    }   
    
}

?>

<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Costumbres</h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="costumbre_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $costumbreNombre; ?>" name="costumbre_nombre" placeholder="Titulo">
            <?php if(isset($errores['nombreVacio'])):?>
                <span class="error-process"><?php echo $errores['nombreVacio']; ?></span>
            <?php endif; ?>
            <?php if(isset($errores['nombreLargo'])):?>
                <span class="error-process"><?php echo $errores['nombreLargo']; ?></span>
            <?php endif; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="costumbre_texto">Texto de la imagen</label>
            <textarea class="configuracion-input" name="costumbre_texto"><?php echo $costumbreTexto; ?></textarea>
            <?php if(isset($errores['textoVacio'])):?>
                <span class="error-process"><?php echo $errores['textoVacio']; ?></span>
            <?php endif; ?>
        </div>
        <div class="configuracion-inp-foto">
            <label class="configuracion-lbl-file"  for="costumbre_foto">Imagen</label>
            <input  class="configuracion-file" type="file" name="costumbre_foto" accept="image/*" id="costumbre_foto" >
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
         <span class="success-process">Agregado Correctamente <a href="index.php?action=readCostumbres">Ver Agregado</a> </span>
         <?php endif; ?>
    </form>
</section>