<?php

$errores = [];

$queryDestacado = mysqli_query($cnx, "SELECT * FROM chuquis_tables WHERE ChuquisCod = 'CHU-CAR' AND destacado = 1");
$resultDestacado = mysqli_fetch_assoc($queryDestacado);

$nombreDestado = $resultDestacado['nombre'];
$codDestado = $resultDestacado['cod'];
$fotoDestado = $resultDestacado['foto'];


$errores = [];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $codigo = mysqli_escape_string($cnx, $_POST['codigo_destacado']);

    if(!$codigo){
        $errores['codigoVacio'] = 'El codigo no debe estar vacio';
    }

    $buscarCodigo = mysqli_query($cnx, "SELECT * FROM chuquis_tables WHERE ChuquisCod = 'CHU-CAR' and cod = '$codigo'");
    
    if($buscarCodigo -> num_rows === 0){
        $errores['codigoNo'] = 'ESte codigo no existe, intente con otro';
    }


    if(empty($errores)){

        $borrarDestacado = mysqli_query($cnx, "UPDATE chuquis_tables SET destacado = 0 WHERE cod = '$codDestado' AND ChuquisCod = 'CHU-CAR'");
        $updDestacado = mysqli_query($cnx, "UPDATE chuquis_tables SET destacado = 1 WHERE cod = '$codigo' AND ChuquisCod = 'CHU-CAR'");

        if($updDestacado){
            header('Location: index.php?action=destacadoCarnavales&actualizado=1');
        }
    }
}
?>

<section class="configuracion">
    <form action="" class="configuracion-form" method="POST">
        <h3 class="configuracion-title">Cambiar imagen destacado de Carnavales</h2>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl" for="codigo_destacado">Codigo de Imagen</label>
            <input type="text" value="<?php echo $codDestado; ?>" name="codigo_destacado">
            <?php echo isset($errores['codigoVacio']) ? "<span class='error-process'>$errores[codigoVacio]</span>" : ''; ?>
            <?php echo isset($errores['codigoNo']) ? "<span class='error-process'>$errores[codigoNo]</span>" : ''; ?>
            <img width="200px" src="./mediaBD/mediaChuquis/carnavales/<?php echo $fotoDestado; ?>" alt="">
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