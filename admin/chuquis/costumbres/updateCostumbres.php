<?php

$costumbresCod = $_GET['CostumbreCod'];
$errores = [];


$querycostumbres = mysqli_query($cnx, "SELECT * FROM chuquis_tables WHERE cod = '$costumbresCod'");
$resultadoQuery = mysqli_fetch_assoc($querycostumbres);

$costumbresNombre    = $resultadoQuery['nombre'];
$costumbresTexto     = $resultadoQuery['texto'];
$costumbresFoto      = $resultadoQuery['foto'];
$costumbresFecha     = $resultadoQuery['fecha'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $costumbres_Nombre = mysqli_escape_string($cnx, trim($_POST['costumbres_nombre'])); 
    $costumbres_Texto = mysqli_escape_string($cnx, trim($_POST['costumbres_texto'])); 
    $costumbres_Foto = $_FILES['costumbres_foto'];

    // validar formulario
    $errores = validarFormulario($errores,$costumbres_Nombre , $costumbres_Texto, $costumbres_Foto, true);
    
   
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $costumbresImagenes   = '/costumbres/';

        $nombreImagen = '';

        if($costumbres_Foto['name']){
            unlink($carpetaMediaBD.$costumbresImagenes.$costumbresFoto );
            $nombreImagen = md5( uniqid( rand(), true)).".jpg";
            move_uploaded_file($costumbres_Foto['tmp_name'], $carpetaMediaBD.$costumbresImagenes.$nombreImagen); 
        }else{
            $nombreImagen = $costumbresFoto ;
        }


        $updcostumbres  = mysqli_query($cnx, "UPDATE chuquis_tables SET nombre = '$costumbres_Nombre', texto ='$costumbres_Texto', foto = '$nombreImagen' WHERE cod = '$costumbresCod'"); //$userCod hereda de index.php
      
        
        if($updcostumbres){
            header('Location: index.php?action=readCostumbres&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Editar Costumbres de <?php echo $costumbresCod; ?></h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="costumbres_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $costumbresNombre; ?>" name="costumbres_nombre" placeholder="Titulo">
                <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : '' ?>
                <?php echo isset($errores['nombreLargo']) ? "<span class='error-process'>$errores[nombreLargo]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="costumbres_texto">Texto de la imagen</label>
            <textarea class="configuracion-textArea" name="costumbres_texto"><?php echo $costumbresTexto; ?></textarea>
                <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : '';?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl-file"  for="costumbres_foto"><i class="fas fa-image"></i> Imagen</label>
            <input  class="configuracion-file" accept="image/*" type="file" name="costumbres_foto" id="costumbres_foto" >
            <img width="200px" src="./mediaBD/mediaChuquis/costumbres/<?php echo $costumbresFoto; ?>" alt="">
            
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