<?php


$errores = [];

$kuyaikiNombre  = '';
$kuyaikiTexto = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $kuyaikiNombre = mysqli_escape_string($cnx, trim($_POST['kuyaiki_nombre']));
    $kuyaikiTexto = mysqli_escape_string($cnx, trim($_POST['kuyaiki_texto']));
    $kuyaikiFoto = $_FILES['kuyaiki_foto'];

    //validar Formulario
    $errores = validarFormulario($errores,$kuyaikiNombre, $kuyaikiTexto, $kuyaikiFoto, $upd = false);

    // si ya no hay errores
    if(empty($errores)){

        $carpetaMediaBD = './mediaBD/';
        $kuyaikiImagenes   = '/mediaKuyaiki/';

        // crear carpeta si no existe
        if(!is_dir($carpetaMediaBD.$kuyaikiImagenes)){
            mkdir($carpetaMediaBD.$kuyaikiImagenes);
        }

        $nombreImagen = md5( uniqid( rand(), true)).".jpg";
        move_uploaded_file($kuyaikiFoto['tmp_name'], $carpetaMediaBD.$kuyaikiImagenes.$nombreImagen); 


        $chuquisCod = 'KUYAIKI';
        $codigoKuyaiki = strtotime(date('c')).date('ymd'); // codigo generador
        $fechaKuyaiki = date('Y/m/d');
        $ruta = 'mediaKuyaiki';

        $addKuyaiki  = mysqli_query($cnx, "INSERT INTO chuquis_tables (cod, nombre, texto, foto, fecha, ChuquisCod, ruta) VALUES ('$codigoKuyaiki','$kuyaikiNombre','$kuyaikiTexto', '$nombreImagen','$fechaKuyaiki', '$chuquisCod','$ruta')");

        if($addKuyaiki){
            header('Location: index.php?action=createKuyaiki&agregado=1');
        }
    }   
    
}

?>
<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <h3 class="configuracion-title">Kuyaiki</h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="kuyaiki_nombre">Titulo de la imagen:</label>
            <input class="configuracion-input" type="text" value="<?php echo $kuyaikiNombre; ?>" name="kuyaiki_nombre" placeholder="Titulo">
            <?php echo isset($errores['nombreVacio']) ? "<span class='error-process'>$errores[nombreVacio]</span>" : ''; ?>
            <?php echo isset($errores['nombreLargo']) ? "<span class=error-process'>$errores[nombreLargo]></span>" : ''; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="kuyaiki_texto">Texto de la imagen</label>
            <textarea class="configuracion-input" name="kuyaiki_texto"><?php echo $kuyaikiTexto; ?></textarea>
            <?php echo isset($errores['textoVacio']) ? "<span class='error-process'>$errores[textoVacio]</span>" : ''; ?>
        </div>
        <div class="configuracion-inp-foto">
            <label class="configuracion-lbl-file"  for="kuyaiki_foto">Imagen</label>
            <input  class="configuracion-file" type="file" name="kuyaiki_foto" accept="image/*" id="kuyaiki_foto" >
            <?php echo isset($errores['fotoNoDisponible']) ? "<span class='error-process'>$errores[fotoNoDisponible]</span>" : ''; ?>
            <?php echo isset($errores['fotoPesado']) ? "<span class='error-process'>$errores[fotoPesado]</span>" : ''; ?>
        </div>
        <input class="configuracion-submit" type="submit" value="Agregar">

        <?php
            $actualizadoCorrectamente = $_GET['agregado']  ?? null;
            if($actualizadoCorrectamente == 1 && empty($errores)):
         ?>
         <span class="success-process">Agregado Correctamente <a href="index.php?action=readKuyaiki">Ver Agregado</a> </span>
         <?php endif; ?>
    </form>
</section>