<?php 
require_once './includes/db.php';
$errores = [];

$correo = '';
$clave = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $correo             = mysqli_escape_string($cnx, $_POST['user_correo']); 
    $clave              = mysqli_escape_string($cnx, $_POST['user_clave']);
    $contraseña         = mysqli_escape_string($cnx, $_POST['user_newpassword']);
    $nuevacontraseña    = mysqli_escape_string($cnx, $_POST['user_repeatnewpassword']);
    
    if(!$correo){
        $errores['correoVacio'] = 'El campo correo no debe estar vacio';
    }
    if(!$clave){
        $errores['claveVacio'] = 'El campo clave no debe estar vacio';
    }
    if(!$contraseña){
        $errores['contraseñaVacio'] = 'El campo nueva contraseña no debe estar vacio';
    }
    if(!$nuevacontraseña){
        $errores['nuevacontraseñaVacio'] = 'El campo nueva repita su contraseña no debe estar vacio';
    }

    $queryForget = mysqli_query($cnx, "SELECT * FROM  users WHERE user_correo = '$correo'");
    
   

    if($queryForget -> num_rows){
        $resultForget = mysqli_fetch_assoc($queryForget);
        $userClave = $resultForget['user_clave'];
        $userCod = $resultForget['user_cod'];
        
        if($clave !== $userClave){
            $errores['claveNo'] = 'Clave INcorrecta';
        }
        
    }else{
        $errores['correoNo'] = 'correo no existe en nuestro sistema';
    
    }

    if($contraseña !== $nuevacontraseña){
        $errores['contraNo'] = 'Las contraseñas deben ser iguales';
    }
    
   

    
    if(empty($errores)){

        
                
        $contraHash = password_hash($nuevacontraseña, PASSWORD_BCRYPT);

        $updClave = mysqli_query($cnx, "UPDATE users SET user_password = '$contraHash' WHERE user_cod = '$userCod'");
        
        if($updClave){
            header('Location:olvidarContraseña.php?correcta=1');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./build/css/app.css">
</head>

<body id="bodyLogin">

    <form action="" class="form" method="POST">
        <h3 class="forget__lbl" >Olvidaste tu contraseña?</h3>
        <label class="forget__lbl" for="">Correo Electronico</label>
        <input class="login__inp" type="text" name="user_correo" value="<?php echo $correo; ?>">
        <?php echo isset($errores['correoVacio']) ? "<span class='error-process'>$errores[correoVacio]</span>" : ''; ?>
        <?php echo isset($errores['correoNo']) ? "<span class='error-process'>$errores[correoNo]</span>" : ''; ?>
        
        <label class="forget__lbl" for="">Clave Personal</label>
        <input class="login__inp" type="text" name="user_clave" value="<?php echo $clave; ?>">
        <?php echo isset($errores['claveVacio']) ? "<span class='error-process'>$errores[claveVacio]</span>" : ''; ?>
        <?php echo isset($errores['claveNo']) ? "<span class='error-process'>$errores[claveNo]</span>" : ''; ?>

        <label class="forget__lbl" for="">Nueva Contraseña</label>
        <input class="login__inp" type="text" name="user_newpassword">
        <?php echo isset($errores['contraseñaVacio']) ? "<span class='error-process'>$errores[contraseñaVacio]</span>" : ''; ?>

        <label class="forget__lbl"  for="">repita su nueva Contraseña</label>
        <input class="login__inp" type="text" name="user_repeatnewpassword">
        <?php echo isset($errores['nuevacontraseñaVacio']) ? "<span class='error-process'>$errores[nuevacontraseñaVacio]</span>" : ''; ?>
        <?php echo isset($errores['contraNo']) ? "<span class='error-process'>$errores[contraNo]</span>" : ''; ?>
        
        <input class="login__btn"  type="submit" value="Recuperar contraseña">
        <?php
         $actualizadoCorrectamente = $_GET['correcta']  ?? null;
        if($actualizadoCorrectamente == 1 && empty($errores)):
         ?>
         <span class="success-process">Actualizado Correctamente <a href="admin">Loguearte</a> </span>
         <?php endif; ?>
    </form>
        
</body>
</html>