<?php

$lugaresturisticosCod = $_GET['lugaresturisticosCod'];
$errores = [];


$querylugaresturisticos = mysqli_query($cnx, "SELECT * FROM chuquis_tables WHERE cod = '$lugaresturisticosCod'");
$resultadoQuery = mysqli_fetch_assoc($querylugaresturisticos);

$lugaresturisticosNombre    = $resultadoQuery['nombre'];
$lugaresturisticosTexto     = $resultadoQuery['texto'];
$lugaresturisticosFoto      = $resultadoQuery['foto'];
$lugaresturisticosFecha     = $resultadoQuery['fecha'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $lugaresturisticos_Nombre = mysqli_escape_string($cnx, trim($_POST['lugaresturisticos_nombre'])); 
    $lugaresturisticos_Texto = mysqli_escape_string($cnx, trim($_POST['lugaresturisticos_texto'])); 
    $lugaresturisticos_Foto = $_FILES['lugaresturisticos_foto'];

    // validar formulario
    $errores = validarFormulario($errores,$lugaresturisticos_Nombre , $lugaresturisticos_Texto, $lugaresturisticos_Foto, true);
    
   
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaTingomaria';
        $lugaresturisticosImagenes   = '/lugaresturisticos/';

        $nombreImagen = '';

        if($lugaresturisticos_Foto['name']){
            unlink($carpetaMediaBD.$lugaresturisticosImagenes.$lugaresturisticosFoto );
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
            move_uploaded_file($lugaresturisticos_Foto['tmp_name'], $carpetaMediaBD.$lugaresturisticosImagenes.$nombreImagen); 
        }else{
            $nombreImagen = $lugaresturisticosFoto ;
        }


        $updlugaresturisticos  = mysqli_query($cnx, "UPDATE chuquis_tables SET nombre = '$lugaresturisticos_Nombre', texto ='$lugaresturisticos_Texto', foto = '$nombreImagen' WHERE cod = '$lugaresturisticosCod'"); 
      
        
        if($updlugaresturisticos){
            header('Location: index.php?action=readLugaresTuristicos&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Editar Lugares Turisticos de <?php echo $lugaresturisticosCod; ?></h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="lugaresturisticos_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $lugaresturisticosNombre; ?>" name="lugaresturisticos_nombre" placeholder="Titulo">
                <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : '' ?>
                <?php echo isset($errores['nombreLargo']) ? "<span class='error-process'>$errores[nombreLargo]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="lugaresturisticos_texto">Texto de la imagen</label>
            <textarea class="configuracion-textArea" name="lugaresturisticos_texto"><?php echo $lugaresturisticosTexto; ?></textarea>
                <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : '';?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="lugaresturisticos_foto"><i class="fas fa-image"></i> Imagen</label>
            <input  class="configuracion-file" accept="image/*" type="file" name="lugaresturisticos_foto" id="lugaresturisticos_foto" >
            <img width="200px" src="./mediaBD/mediaTingomaria/lugaresturisticos/<?php echo $lugaresturisticosFoto; ?>" alt="">
            
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