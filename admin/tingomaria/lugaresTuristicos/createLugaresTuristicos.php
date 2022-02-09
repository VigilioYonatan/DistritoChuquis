<?php


$errores = [];

$lugaresturisticosNombre  = '';
$lugaresturisticosTexto = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $lugaresturisticosNombre = mysqli_escape_string($cnx, trim($_POST['lugaresturisticos_nombre']));
    $lugaresturisticosTexto = mysqli_escape_string($cnx, trim($_POST['lugaresturisticos_texto']));
    $lugaresturisticosFoto = $_FILES['lugaresturisticos_foto'];

    //validar Formulario
    $errores = validarFormulario($errores,$lugaresturisticosNombre, $lugaresturisticosTexto, $lugaresturisticosFoto, $upd = false);

    // si ya no hay errores
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/mediaTingomaria';
        $lugaresturisticosImagenes   = '/lugaresturisticos/';

        // crear carpeta si no existe
        if(!is_dir($carpetaMediaBD.$lugaresturisticosImagenes)){
            mkdir($carpetaMediaBD.$lugaresturisticosImagenes);
        }

        $nombreImagen = md5( uniqid( rand(), true)).".jpg";
        move_uploaded_file($lugaresturisticosFoto['tmp_name'], $carpetaMediaBD.$lugaresturisticosImagenes.$nombreImagen); 


        $chuquisCod = 'TINGO';
        $codigoLugaresturisticos = strtotime(date('c')).date('ymd'); // codigo generador
        $fechaLugaresturisticos = date('Y/m/d');
        $ruta = 'mediaTingomaria/lugaresturisticos';

        $addLugaresturisticos  = mysqli_query($cnx, "INSERT INTO chuquis_tables (cod, nombre, texto, foto, fecha, ChuquisCod, ruta) VALUES ('$codigoLugaresturisticos','$lugaresturisticosNombre','$lugaresturisticosTexto', '$nombreImagen','$fechaLugaresturisticos', '$chuquisCod', '$ruta')");
        
        if($addLugaresturisticos){
            header('Location: index.php?action=createLugaresTuristicos&agregado=1');
        }
    }   
    
}

?>
<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Tingo Maria Lugares TUristicos</h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="lugaresturisticos_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $lugaresturisticosNombre; ?>" name="lugaresturisticos_nombre" placeholder="Titulo">
            <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : ''; ?>
            <?php echo isset($errores['nombreLargo']) ? "<span class=error-process'>$errores[nombreLargo]></span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="lugaresturisticos_texto">Texto de la imagen</label>
            <textarea class="configuracion-input" name="lugaresturisticos_texto"><?php echo $lugaresturisticosTexto; ?></textarea>
            <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp-foto">
            <label class="configuracion-lbl-file"  for="lugaresturisticos_foto">Imagen</label>
            <input  class="configuracion-file" type="file" name="lugaresturisticos_foto" accept="image/*" id="lugaresturisticos_foto" >
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : ''; ?>
        </div>
        <input class="configuracion-submit" type="submit" value="Agregar">

        <?php
            $actualizadoCorrectamente = $_GET['agregado']  ?? null;
            if($actualizadoCorrectamente == 1 && empty($errores)):
         ?>
         <span class="success-process">Agregado Correctamente <a href="index.php?action=readLugaresTuristicos">Ver Agregado</a> </span>
         <?php endif; ?>
    </form>
</section>