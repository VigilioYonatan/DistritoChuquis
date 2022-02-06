<?php

$costumbreCod = $_GET['costumbreCod'];
$errores = [];


$queryCostumbre = mysqli_query($cnx, "SELECT * FROM costumbre WHERE costumbre_cod = '$costumbreCod'");
$resultadoQuery = mysqli_fetch_assoc($queryCostumbre);

$costumbreNombre    = $resultadoQuery['costumbre_nombre'];
$costumbreTexto     = $resultadoQuery['costumbre_texto'];
$costumbreFoto      = $resultadoQuery['costumbre_foto'];
$costumbreFecha     = $resultadoQuery['costumbre_fecha'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){



    $costumbre_Nombre = mysqli_escape_string($cnx, trim($_POST['costumbre_nombre'])); 
    $costumbre_Texto = mysqli_escape_string($cnx, trim($_POST['costumbre_texto'])); 
    $costumbre_Foto = $_FILES['costumbre_foto'];

   
    // var_dump($user_foto);
    // exit;
    if(!$costumbre_Nombre){
        $errores['nombreVacio'] = 'El nombre no debe estar Vacio';
    }

    if(strlen($costumbre_Nombre) > 50){
        $errores['nombreLargo'] = 'Nombre demasiado Largo max 50';
    }

    if(!$costumbre_Texto){
        $errores['textoVacio'] = 'El texto no debe estar vacio';
    }

 

    

  
    if($costumbre_Foto['size'] > 5000000){
        $errores['fotoPesado'] = 'Imagen Muy pesado, menos de 5MB';
    }



    if( $costumbre_Foto['type'] !== 'image/jpeg' && $costumbre_Foto['type'] !== 'image/jpg' && $costumbre_Foto['type'] !== 'image/png' && $costumbre_Foto['type'] !== 'image/webp' && !$costumbre_Foto['error']){
        $errores['fotoNoDisponible'] = 'Insertar Imagen obligatoriamente en formato imagen';
    }

    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $costumbresImagenes   = '/costumbres/';

        $nombreImagen = '';

        if($costumbre_Foto['name']){
            unlink($carpetaMediaBD.$costumbresImagenes.$costumbreFoto );
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
            move_uploaded_file($costumbre_Foto['tmp_name'], $carpetaMediaBD.$costumbresImagenes.$nombreImagen); 
        }else{
            $nombreImagen = $costumbreFoto ;
        }


        $updCostumbre  = mysqli_query($cnx, "UPDATE costumbre SET costumbre_nombre = '$costumbre_Nombre', costumbre_texto ='$costumbre_Texto', costumbre_foto = '$nombreImagen' WHERE costumbre_cod = '$costumbreCod'"); //$userCod hereda de index.php
      
        
        if($updCostumbre){
            header('Location: index.php?action=readCostumbres');
        }
    }   
    
}

?>

<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Editar Costumbres de <?php echo $costumbreCod; ?></h3>
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
            <textarea class="configuracion-textArea" name="costumbre_texto"><?php echo $costumbreTexto; ?></textarea>
            <?php if(isset($errores['textoVacio'])):?>
                <span class="error-process"><?php echo $errores['textoVacio']; ?></span>
            <?php endif; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="costumbre_foto"><i class="fas fa-image"></i> Imagen</label>
            <input  class="configuracion-file" accept="image/*" type="file" name="costumbre_foto" id="costumbre_foto" >
            <img width="200px" src="./mediaBD/mediaChuquis/costumbres/<?php echo $costumbreFoto; ?>" alt="">

            <?php if(isset($errores['fotoNoDisponible'])): ?>
                <span class="error-process"><?php echo $errores['fotoNoDisponible']; ?></span>
            <?php  endif;?>
            <?php if(isset($errores['fotoPesado'])): ?>
                <span class="error-process"><?php echo $errores['fotoPesado']; ?></span>
            <?php  endif;?>
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