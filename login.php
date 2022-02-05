<?php
require_once './includes/db.php';
session_start();

if(isset($_SESSION['login'])){
    header('Location: admin/index.php');
}


$errores = [];

$userCorreo = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $userCorreo = mysqli_escape_string($cnx, filter_var($_POST['user_correo'], FILTER_VALIDATE_EMAIL));
    $userPassword = mysqli_escape_string($cnx, $_POST['user_password']);

    if(!$userCorreo){
        $errores['correoVacio'] = 'Introduce un correo Electrónico';
    }

    if(!$userPassword){
        $errores['passwordVacio'] = 'Introduce una contraseña';
    }
    

    if(empty($errores)){

        $queryUser = mysqli_query($cnx, "SELECT * FROM users WHERE user_correo = '$userCorreo'");
        

        $resultadoQuery = mysqli_fetch_assoc($queryUser);

        if($resultadoQuery){

            $contraseñaCod = $resultadoQuery['user_cod'];
            $contraseñaUser = $resultadoQuery['user_password'];

            $contraseña = password_verify($userPassword , $contraseñaUser);
            

            if($contraseña){
                session_start();
                $_SESSION['userCod'] = $contraseñaCod;
                $_SESSION['login'] = true;

                header('Location: admin/index.php');
            }else{
                $errores['passwordMal'] = 'Contraseña Incorrecta';
            }


        }else{
            $errores['correoMal'] = 'Este correo no existe';
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
    <title>Login</title>
    <link rel="stylesheet" href="./build/css/app.css">
</head>
<body id="bodyLogin">
    <form action="" class="form" method="POST">
        <div class="login">
            <label for="">Correo Electronico:</label>
            <input class="login__inp" type="text" name="user_correo" placeholder="Nombre de Usuario" value="<?php echo $userCorreo; ?>">
            <?php if(isset($errores['correoVacio'])):?>
                <span><?php echo $errores['correoVacio']; ?></span>
            <?php endif; ?>
            <?php if(isset($errores['correoMal']) && !isset($errores['correoVacio'])):?>
                <span><?php echo $errores['correoMal']; ?></span>
            <?php endif; ?>
        </div>
        <div class="login">
            <label for="">Contraseña:</label>
            <input  class="login__inp" type="password" name="user_password" placeholder="Contraseña">
            <?php if(isset($errores['passwordVacio'])):?>
                <span><?php echo $errores['passwordVacio']; ?></span>
            <?php endif; ?>
            <?php if(!isset($errores['passwordVacio']) && isset($errores['passwordMal'])):?>
                <span><?php echo $errores['passwordMal']; ?></span>
            <?php endif; ?>
        </div>
        <input class="login__btn" type="submit" value="Ingresar">
        <div class="forget">
            <a class="forget__olvidar" href="olvidarContraseña.php">Me olvide La Contraseña</a>
            <a class="forget__crear" href="">Crear cuenta</a>
        </div>
    </form>
</body>
</html>
