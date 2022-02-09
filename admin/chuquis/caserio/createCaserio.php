<?php


$errores = [];

$caserioNombre  = '';
$caserioTexto = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $caserioNombre = mysqli_escape_string($cnx, trim($_POST['caserio_nombre']));
    $caserioTexto = mysqli_escape_string($cnx, trim($_POST['caserio_texto']));
    $caserioFoto = $_FILES['caserio_foto'];

    //validar Formulario
    $errores = validarFormulario($errores,$caserioNombre, $caserioTexto, $caserioFoto, $upd = false);

    // si ya no hay errores
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaChuquis';
        $caserioImagenes   = '/caserio/';

        // crear carpeta si no existe
        if(!is_dir($carpetaMediaBD.$caserioImagenes)){
            mkdir($carpetaMediaBD.$caserioImagenes);
        }

        $nombreImagen = md5( uniqid( rand(), true)).".jpg";
        move_uploaded_file($caserioFoto['tmp_name'], $carpetaMediaBD.$caserioImagenes.$nombreImagen); 


        $chuquisCod = 'CHU-CAS';
        $codigoCaserio = strtotime(date('c')).date('ymd'); // codigo generador
        $fechaCaserio = date('Y/m/d');
        $ruta = 'mediaChuquis/caserio';
        $addCaserio  = mysqli_query($cnx, "INSERT INTO chuquis_tables (cod, nombre, texto, foto, fecha, ChuquisCod,ruta) VALUES ('$codigoCaserio','$caserioNombre','$caserioTexto', '$nombreImagen','$fechaCaserio', '$chuquisCod', '$ruta')");
      
        
        if($addCaserio){
            header('Location: index.php?action=createCaserio&agregado=1');
        }
    }   
    
}

?>
<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Caserios</h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="caserio_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $caserioNombre; ?>" name="caserio_nombre" placeholder="Titulo">
            <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : ''; ?>
            <?php echo isset($errores['nombreLargo']) ? "<span class=error-process'>$errores[nombreLargo]></span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="caserio_texto">Texto de la imagen</label>
            <textarea class="configuracion-input" name="caserio_texto"><?php echo $caserioTexto; ?></textarea>
            <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp-foto">
            <label class="configuracion-lbl-file"  for="caserio_foto">Imagen</label>
            <input  class="configuracion-file" type="file" name="caserio_foto" accept="image/*" id="caserio_foto" >
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : ''; ?>
        </div>
        <input class="configuracion-submit" type="submit" value="Agregar">

        <?php
            $actualizadoCorrectamente = $_GET['agregado']  ?? null;
            if($actualizadoCorrectamente == 1 && empty($errores)):
         ?>
         <span class="success-process">Agregado Correctamente <a href="index.php?action=readCaserio">Ver Agregado</a> </span>
         <?php endif; ?>
    </form>
</section>