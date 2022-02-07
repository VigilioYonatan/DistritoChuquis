<?php

$caserioCod = $_GET['caserioCod'];
$errores = [];


$querycaserio = mysqli_query($cnx, "SELECT * FROM caserio WHERE caserio_cod = '$caserioCod'");
$resultadoQuery = mysqli_fetch_assoc($querycaserio);

$caserioNombre    = $resultadoQuery['caserio_nombre'];
$caserioTexto     = $resultadoQuery['caserio_texto'];
$caserioFoto      = $resultadoQuery['caserio_foto'];
$caserioFecha     = $resultadoQuery['caserio_fecha'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $caserio_Nombre = mysqli_escape_string($cnx, trim($_POST['caserio_nombre'])); 
    $caserio_Texto = mysqli_escape_string($cnx, trim($_POST['caserio_texto'])); 
    $caserio_Foto = $_FILES['caserio_foto'];

    // validar formulario
    $errores = validarFormulario($errores,$caserio_Nombre , $caserio_Texto, $caserio_Foto, true);
    
   
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $caserioImagenes   = '/caserio/';

        $nombreImagen = '';

        if($caserio_Foto['name']){
            unlink($carpetaMediaBD.$caserioImagenes.$caserioFoto );
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
            move_uploaded_file($caserio_Foto['tmp_name'], $carpetaMediaBD.$caserioImagenes.$nombreImagen); 
        }else{
            $nombreImagen = $caserioFoto ;
        }


        $updcaserio  = mysqli_query($cnx, "UPDATE caserio SET caserio_nombre = '$caserio_Nombre', caserio_texto ='$caserio_Texto', caserio_foto = '$nombreImagen' WHERE caserio_cod = '$caserioCod'"); //$userCod hereda de index.php
      
        
        if($updcaserio){
            header('Location: index.php?action=readCaserio&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Editar Caserio de <?php echo $caserioCod; ?></h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="caserio_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $caserioNombre; ?>" name="caserio_nombre" placeholder="Titulo">
                <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : '' ?>
                <?php echo isset($errores['nombreLargo']) ? "<span class='error-process'>$errores[nombreLargo]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="caserio_texto">Texto de la imagen</label>
            <textarea class="configuracion-textArea" name="caserio_texto"><?php echo $caserioTexto; ?></textarea>
                <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : '';?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="caserio_foto"><i class="fas fa-image"></i> Imagen</label>
            <input  class="configuracion-file" accept="image/*" type="file" name="caserio_foto" id="caserio_foto" >
            <img width="200px" src="./mediaBD/mediaChuquis/caserio/<?php echo $caserioFoto; ?>" alt="">
            
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