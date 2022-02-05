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

        $userImagenes = './usersImagenes/';

        //crear carpeta si no exister
        if(!is_dir($userImagenes)){
            mkdir($userImagenes);
        }

        $nombreImagen = '';


        // si pone una imagen el usuario
        if($user_foto['name']){
                unlink($userImagenes.$userFoto);

                //hasheeamos el nombre de la imagen
                $nombreImagen = md5( uniqid( rand(), true)).".jpg";
    
                move_uploaded_file($user_foto['tmp_name'], $userImagenes.$nombreImagen);     
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
            <label class="configuracion-lbl"  for="">Código:</label>
            <span class="configuracion-info"><?php echo $userCod ?></span>
        </div>
        <div class="configuracion-inp">
            <label class="configuracion-lbl"  for="user_nombre">Nombre:</label>
            <input type="text" value="<?php echo $userNombre; ?>" name="user_name">
            <?php if(isset($errores['nombreVacio'])):?>
                <span><?php echo $errores['nombreVacio']; ?></span>
            <?php endif; ?>
        </div>
        <div class="configuracion-inp">
            <label class="configuracion-lbl"  for="user_apellido">Apellido</label>
            <input type="text" value="<?php echo $userApellido; ?>" name="user_apellido">
            <?php if(isset($errores['apellidoVacio'])):?>
                <span><?php echo $errores['apellidoVacio']; ?></span>
            <?php endif; ?>
        </div>
        <div class="configuracion-inp">
            <label class="configuracion-lbl"  for="">Correo Electrónico:</label>
            <span class="configuracion-info"><?php echo $userCorreo ?></span>
        </div>
        <div class="configuracion-inp">
            <label class="configuracion-lbl"  for="user_foto">Foto:</label>
            <input type="file" name="user_foto" >
            <?php if(isset($errores['fotoNoDisponible'])): ?>
                <span><?php echo $errores['fotoNoDisponible']; ?></span>
            <?php  endif;?>
            <?php if(isset($errores['fotoPesado'])): ?>
                <span><?php echo $errores['fotoPesado']; ?></span>
            <?php  endif;?>
            <img width="100px" src="./usersImagenes/<?php echo $userFoto; ?>" alt="">
        </div>
        <div class="configuracion-inp">
            <label class="configuracion-lbl"  for="user_fecha">Creado el:</label>
            <span class="configuracion-info"><?php echo $userFecha ?></span>
        </div>
        <div class="configuracion-inp">
            <label class="configuracion-lbl"  for="user_clave">Clave:</label>
            <input type="text" value="<?php echo $userClave; ?>" name="user_clave">
            <?php if(isset($errores['claveVacio'])):?>
                <span><?php echo $errores['claveVacio']; ?></span>
            <?php endif; ?>
        </div>
        <input type="submit" value="Actualizar">

        <?php
            $actualizadoCorrectamente = $_GET['actualizado']  ?? null;
            if($actualizadoCorrectamente == 1 && empty($errores)):
         ?>
         <span>Actualizado Correctamente</span>
         <?php endif; ?>
    </form>
</section>