<?php

$errores = [];


if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $user_nombre =  mysqli_escape_string($cnx, $_POST['user_name']); 
    $user_apellido= mysqli_escape_string($cnx, $_POST['user_apellido']);
    $user_foto =    $_FILES['user_foto'];
    $user_clave =   mysqli_escape_string($cnx, $_POST['user_clave']);
   
    // var_dump($user_foto);
    // exit;
    if(!$user_nombre){
        $errores['nombreVacio'] = 'El nombre no debe estar Vacio';
    }

    if(strlen($user_nombre) > 15){
        $errores['nombreLargo'] = 'Nombre demasiado Largo max 15';
    }

    if(!$user_apellido){
        $errores['apellidoVacio'] = 'El apellido no debe estar vacio';
    }

    if(!$user_clave){
        $errores['claveVacio'] = 'Tu clave no debe estar vacio';
    }

    

  
    if($user_foto['size'] > 2000000){
        $errores['fotoPesado'] = 'Imagen Muy pesado, menos de 2MB';
    }

    if( $user_foto['type'] !== 'image/jpeg' && $user_foto['type'] !== 'image/jpg' && $user_foto['type'] !== 'image/png' && $user_foto['type'] !== 'image/webp' && !$user_foto['error']){
        $errores['fotoNoDisponible'] = 'Imagen no disponible';
    }

    if(empty($errores)){

        $carpetaMediaBD = './mediaBD';
        $userImagenes   = '/mediaUsers/';

        //crear carpeta si no exister
        if(!is_dir($carpetaMediaBD.$userImagenes)){
            mkdir($carpetaMediaBD.$userImagenes);
        }

        $nombreImagen = '';


        // si pone una imagen el usuario
        if($user_foto['name']){
                unlink($carpetaMediaBD.$userImagenes.$userFoto);

                //hasheeamos el nombre de la imagen
                $nombreImagen = md5( uniqid( rand(), true)).".jpg";
    
                move_uploaded_file($user_foto['tmp_name'], $carpetaMediaBD.$userImagenes.$nombreImagen);     
        }else{
            $nombreImagen = $userFoto;
        }

     
        
        $updateUser  = mysqli_query($cnx, "UPDATE users SET user_nombre = '$user_nombre', user_apellido = '$user_apellido', user_foto = '$nombreImagen', user_clave = '$user_clave' WHERE user_Cod = '$userCod' "); //$userCod hereda de index.php

        
        if($updateUser){
            header('Location: index.php?action=configuracion&actualizado=1');
        }
    }   
    
}

?>

<section class="configuracion">
    <form action="" class="configuracion-form" method="POST" enctype="multipart/form-data">
        <div class="configuracion-inp">
            <label class="configuracion-lbl"  for=""><i class="fas fa-key"></i> Código:</label>
            <span class="configuracion-info"><?php echo $userCod ?></span>
        </div>
        <div class="configuracion-inp">
            <label class="configuracion-lbl"  for="user_nombre"><i class="fas fa-user"></i> Nombre:</label>
            <input class="configuracion-input" type="text" value="<?php echo $userNombre; ?>" name="user_name">
            <?php if(isset($errores['nombreVacio'])):?>
                <span class="error-process"><?php echo $errores['nombreVacio']; ?></span>
            <?php endif; ?>
        </div>
        <div class="configuracion-inp">
            <label class="configuracion-lbl"  for="user_apellido"><i class="fas fa-people-arrows"></i> Apellido</label>
            <input class="configuracion-input" type="text" value="<?php echo $userApellido; ?>" name="user_apellido">
            <?php if(isset($errores['apellidoVacio'])):?>
                <span class="error-process"><?php echo $errores['apellidoVacio']; ?></span>
            <?php endif; ?>
        </div>
        <div class="configuracion-inp">
            <label class="configuracion-lbl"  for=""><i class="fas fa-envelope"></i> Correo Electrónico:</label>
            <span class="configuracion-info"><?php echo $userCorreo ?></span>
        </div>
        <div class="configuracion-inp">
            <label class="configuracion-lbl"  for="user_fecha"><i class="fas fa-table"></i> Creado el:</label>
            <span class="configuracion-info"><?php echo $userFecha ?></span>
        </div>
        <div class="configuracion-inp">
            <label class="configuracion-lbl"  for="user_clave">Clave:</label>
            <input class="configuracion-input" type="text" value="<?php echo $userClave; ?>" name="user_clave">
            <?php if(isset($errores['claveVacio'])):?>
                <span class="error-process"><?php echo $errores['claveVacio']; ?></span>
            <?php endif; ?>
        </div>
        <div class="configuracion-inp-foto">
            <label class="configuracion-lbl-file"  for="user_foto"><i class="fas fa-image"></i> Foto de Perfil</label>
            <input  class="configuracion-file" type="file" name="user_foto" id="user_foto">
            <?php if(isset($errores['fotoNoDisponible'])): ?>
                <span class="error-process"><?php echo $errores['fotoNoDisponible']; ?></span>
            <?php  endif;?>
            <?php if(isset($errores['fotoPesado'])): ?>
                <span class="error-process"><?php echo $errores['fotoPesado']; ?></span>
            <?php  endif;?>
            <img class="configuracion-inp-foto__img" src="./mediaBD/mediaUsers/<?php echo $userFoto; ?>" alt="">
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