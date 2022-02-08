<?php


$errores = [];

$costumbresNombre  = '';
$costumbresTexto = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $costumbresNombre = mysqli_escape_string($cnx, trim($_POST['costumbres_nombre']));
    $costumbresTexto = mysqli_escape_string($cnx, trim($_POST['costumbres_texto']));
    $costumbresFoto = $_FILES['costumbres_foto'];

    //validar Formulario
    $errores = validarFormulario($errores,$costumbresNombre, $costumbresTexto, $costumbresFoto, $upd = false);

    // si ya no hay errores
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $costumbresImagenes   = '/costumbres/';

        // crear carpeta si no existe
        if(!is_dir($carpetaMediaBD.$costumbresImagenes)){
            mkdir($carpetaMediaBD.$costumbresImagenes);
        }

        $nombreImagen = md5( uniqid( rand(), true)).".jpg";
        move_uploaded_file($costumbresFoto['tmp_name'], $carpetaMediaBD.$costumbresImagenes.$nombreImagen); 


        $chuquisCod = 'CHU-COS';
        $codigoCostumbres = date('Y'.'m'.'d'.'s');
        $fechaCostumbres = date('Y/m/d');

        $addCostumbres  = mysqli_query($cnx, "INSERT INTO costumbre (costumbre_cod, costumbre_nombre, costumbre_texto, costumbre_foto,costumbre_fecha, costumbre_ChuquisCod) VALUES ('$codigoCostumbres','$costumbresNombre','$costumbresTexto', '$nombreImagen','$fechaCostumbres', '$chuquisCod')");
      
        
        if($addCostumbres){
            header('Location: index.php?action=createCostumbres&agregado=1');
        }
    }   
    
}

?>
<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Costumbres</h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="costumbres_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $costumbresNombre; ?>" name="costumbres_nombre" placeholder="Titulo">
            <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : ''; ?>
            <?php echo isset($errores['nombreLargo']) ? "<span class=error-process'>$errores[nombreLargo]></span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="costumbres_texto">Texto de la imagen</label>
            <textarea class="configuracion-input" name="costumbres_texto"><?php echo $costumbresTexto; ?></textarea>
            <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp-foto">
            <label class="configuracion-lbl-file"  for="costumbres_foto">Imagen</label>
            <input  class="configuracion-file" type="file" name="costumbres_foto" accept="image/*" id="costumbres_foto" >
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : ''; ?>
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