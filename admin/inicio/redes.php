<?php

$errores = [];

$queryInicio = mysqli_query($cnx, "SELECT * FROM inicio");
$resultadoQuery = mysqli_fetch_assoc($queryInicio);

$inicioFacebook = $resultadoQuery['inicio_facebook'];
$inicioWhatsapp = $resultadoQuery['inicio_whatsapp'];
$inicioYoutube = $resultadoQuery['inicio_youtube'];


if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $inicio_facebook =   mysqli_escape_string($cnx, $_POST['inicio_facebook']); 
    $inicio_wsp      =   mysqli_escape_string($cnx, $_POST['inicio_wsp']);
    $inicio_youtube  =   mysqli_escape_string($cnx, $_POST['inicio_youtube']); 
 


    if(empty($errores)){


        
        $updateUser  = mysqli_query($cnx, "UPDATE inicio SET inicio_facebook = '$inicio_facebook', inicio_whatsapp = '$inicio_wsp', inicio_youtube = '$inicio_youtube'"); //$userCod hereda de index.php

        
        if($updateUser){
            header('Location: index.php?action=redes&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
    <h3 class="configuracion-title"> Redes Sociales</h3>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="inicio_facebook"><i class="fab fa-facebook-square"></i> Facebook:</label>
            <input class="configuracion-input" type="text" value="<?php echo $inicioFacebook; ?>" name="inicio_facebook">
            <?php if(isset($errores['nombreVacio'])):?>
                <span class="error-process"><?php echo $errores['nombreVacio']; ?></span>
            <?php endif; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="inicio_wsp"><i class="fab fa-whatsapp"></i> Whatsapp:</label>
            <input class="configuracion-input" type="text" value="<?php echo $inicioWhatsapp; ?>" name="inicio_wsp">
            <?php if(isset($errores['nombreVacio'])):?>
                <span class="error-process"><?php echo $errores['nombreVacio']; ?></span>
            <?php endif; ?>
        </div>
        <div class="configuracion-inp center">
            <label class="configuracion-lbl"  for="inicio_youtube"><i class="fab fa-youtube"></i> Youtube:</label>
            <input class="configuracion-input" type="text" value="<?php echo $inicioYoutube; ?>" name="inicio_youtube">
            <?php if(isset($errores['nombreVacio'])):?>
                <span class="error-process"><?php echo $errores['nombreVacio']; ?></span>
            <?php endif; ?>
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