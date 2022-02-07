<?php
require_once '../includes/db.php';
require_once './funciones.php';

session_start();

//obtener Datos de usuario
$userCod = $_SESSION['userCod'];

$userQuery = mysqli_query($cnx, "SELECT * FROM users WHERE user_cod = '$userCod'");

if($userQuery -> num_rows){
  
  //Obtener el resultado de la query
  $resultadoQuery = mysqli_fetch_assoc($userQuery);

  $userNombre = $resultadoQuery['user_nombre'];
  $userApellido = $resultadoQuery['user_apellido'];
  $userCorreo = $resultadoQuery['user_correo'];
  $userFoto = $resultadoQuery['user_foto'];
  $userFecha = $resultadoQuery['user_fecha'];
  $userClave = $resultadoQuery['user_clave'];

}else{
  header('Location: ../login.php');
}
 

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../build/css/app.css?<?php echo date('s'); ?>" />
    <title>CSS GRID DASHBOARD</title>
  </head>
  <body id="bodyAdmin">
    <div class="container">
      <div class="settings">
        <div class="settings-links">
          <div class="links-image">
            <a href="#"><img src="./mediaBD/mediaUsers/<?php echo $userFoto; ?>" alt=""></a>
            <span><?php echo $userNombre; ?></span>
          </div>
          <section class="links-link">
            <div class="link">
              <span class="link-title">Inicio</span>
              <a href="index.php?action=updateFotoWelcome">Foto - video Welcome</a>
              <a href="index.php?action=redes">Redes Sociales</a>
            </div>
            <div class="link">
              <span class="link-title">Distrito Chuquis</span>
              <a href="index.php?action=readCostumbres">Costumbres</a>
              <a href="index.php?action=readFlora">Flora</a>
              <a href="index.php?action=readFauna">Fauna</a>
              <a href="index.php?action=readTurismo">Turismo</a>
            </div>
            <div class="link">
              <span class="link-title">Tingo Maria</span>
              <a href="">Inicio Wallpaper</a>
              <a href="">Inicio Wallpaper</a>
              <a href="">Inicio Wallpaper</a>
            </div>
            <div class="link">
              <span class="link-title">Blog Personal</span>
              <a href="">Inicio Wallpaper</a>
              <a href="">Inicio Wallpaper</a>
              <a href="">Inicio Wallpaper</a>
            </div>
            <div class="link">
              <span class="link-title">Kuyaiki</span>
              <a href="">Inicio Wallpaper</a>
              <a href="">Inicio Wallpaper</a>
              <a href="">Inicio Wallpaper</a>
            </div>
            <div class="link">
              <span class="link-title">Soporte</span>
              <a href="">Inicio Wallpaper</a>
              <a href="">Inicio Wallpaper</a>
              <a href="">Inicio Wallpaper</a>
              
            </div>
            <div class="link">
              <a href="index.php?action=configuracion" class="link-title">Configuracion</a>
              <a class="link__salir" href="../logout.php">Salir</a>
            </div>
          </section>
        </div>
      </div>
      <div class="crud">

      <!-- controlador -->
      <?php
      if(isset($_GET['action'])){
        $action = $_GET['action'];
      }else{
        $action = '';
      }

      switch ($action) {
        case 'configuracion':
          require_once 'configuracion.php';
          break;
          // inicio
        case 'updateFotoWelcome':
          require_once 'inicio/updateFotoWelcome.php';
          break;
        case 'redes':
          require_once 'inicio/redes.php';
          break;

          // chuquis-costumbres
        case 'createCostumbres':
          require_once 'chuquis/costumbres/createCostumbres.php';
          break;
          
        case 'readCostumbres':
          require_once 'chuquis/costumbres/readCostumbres.php';
          break;

        case 'updateCostumbres':
          require_once 'chuquis/costumbres/updateCostumbres.php';
          break;

        case 'updCostumbres':
          require_once 'chuquis/flora/updFlora.php';
          break;

          // chuquis-flora
        case 'createFlora':
          require_once 'chuquis/flora/createFlora.php';
          break;
          
        case 'readFlora':
          require_once 'chuquis/flora/readFlora.php';
          break;

        case 'updateFlora':
          require_once 'chuquis/flora/updateFlora.php';
          break;

        case 'updFlora':
          require_once 'chuquis/flora/updFlora.php';
          break;

          // chuquis-fauna
        case 'createFauna':
          require_once 'chuquis/fauna/createFauna.php';
          break;
          
        case 'readFauna':
          require_once 'chuquis/fauna/readFauna.php';
          break;

        case 'updateFauna':
          require_once 'chuquis/fauna/updateFauna.php';
          break;

        case 'updFauna':
          require_once 'chuquis/fauna/updFauna.php';
          break;
        
          // chuquis-turismo
        case 'createTurismo':
          require_once 'chuquis/turismo/createTurismo.php';
          break;
          
        case 'readTurismo':
          require_once 'chuquis/turismo/readTurismo.php';
          break;

        case 'updateTurismo':
          require_once 'chuquis/turismo/updateTurismo.php';
          break;

        case 'updTurismo':
          require_once 'chuquis/turismo/updTurismo.php';
          break;
        
        default:
          # code...
          break;
      }

      ?>

      </div>
    </div>
    <script src="../build/js/bundle.min.js"></script>
  </body>
</html>
