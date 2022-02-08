<?php

$carnavalesCod = $_GET['carnavalesCod'];
$errores = [];


$querycarnavales = mysqli_query($cnx, "SELECT * FROM chuquis_tables WHERE cod = '$carnavalesCod'");
$resultadoQuery = mysqli_fetch_assoc($querycarnavales);

$carnavalesNombre    = $resultadoQuery['nombre'];
$carnavalesTexto     = $resultadoQuery['texto'];
$carnavalesFoto      = $resultadoQuery['foto'];
$carnavalesFecha     = $resultadoQuery['fecha'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $carnavales_Nombre = mysqli_escape_string($cnx, trim($_POST['carnavales_nombre'])); 
    $carnavales_Texto = mysqli_escape_string($cnx, trim($_POST['carnavales_texto'])); 
    $carnavales_Foto = $_FILES['carnavales_foto'];

    // validar formulario
    $errores = validarFormulario($errores,$carnavales_Nombre , $carnavales_Texto, $carnavales_Foto, true);
    
   
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $carnavalesImagenes   = '/carnavales/';

        $nombreImagen = '';

        if($carnavales_Foto['name']){
            unlink($carpetaMediaBD.$carnavalesImagenes.$carnavalesFoto );
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
            move_uploaded_file($carnavales_Foto['tmp_name'], $carpetaMediaBD.$carnavalesImagenes.$nombreImagen); 
        }else{
            $nombreImagen = $carnavalesFoto ;
        }


        $updcarnavales  = mysqli_query($cnx, "UPDATE chuquis_tables SET nombre = '$carnavales_Nombre', texto ='$carnavales_Texto', foto = '$nombreImagen' WHERE cod = '$carnavalesCod'"); 
      
        
        if($updcarnavales){
            header('Location: index.php?action=readCarnavales&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Editar Carnavales de <?php echo $carnavalesCod; ?></h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="carnavales_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $carnavalesNombre; ?>" name="carnavales_nombre" placeholder="Titulo">
                <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : '' ?>
                <?php echo isset($errores['nombreLargo']) ? "<span class='error-process'>$errores[nombreLargo]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="carnavales_texto">Texto de la imagen</label>
            <textarea class="configuracion-textArea" name="carnavales_texto"><?php echo $carnavalesTexto; ?></textarea>
                <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : '';?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="carnavales_foto"><i class="fas fa-image"></i> Imagen</label>
            <input  class="configuracion-file" accept="image/*" type="file" name="carnavales_foto" id="carnavales_foto" >
            <img width="200px" src="./mediaBD/mediaChuquis/carnavales/<?php echo $carnavalesFoto; ?>" alt="">
            
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