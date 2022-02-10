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
    <title>Admin</title>
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
              <a href="index.php?action=readCaserio">Caserios</a>
              <a href="index.php?action=readGeografia">Geografía</a>
              <a href="index.php?action=readCarnavales">Carnavales</a>
              <a href="index.php?action=readSitiosarqueologicos">Sitios Arqueologicos</a>
            </div>
            <div class="link">
              <span class="link-title">Tingo Maria</span>
                <a href="index.php?action=readLugaresTuristicos">Lugares Turisticos</a>
            </div>
            <div class="link">
              <span class="link-title">Blog Personal</span>
                <a href="index.php?action=readBlog">Blog</a>
            </div>
            <div class="link">
              <span class="link-title">Kuyaiki</span>
                <a href="index.php?action=readKuyaiki">Kuyaiki</a>
            </div>
            <div class="link">
              <span class="link-title">Soporte</span>
         
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
          require_once 'chuquis/costumbres/updCostumbres.php';
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

          // chuquis-caserio
        case 'createCaserio':
          require_once 'chuquis/caserio/createCaserio.php';
          break;
          
        case 'readCaserio':
          require_once 'chuquis/caserio/readCaserio.php';
          break;

        case 'updateCaserio':
          require_once 'chuquis/caserio/updateCaserio.php';
          break;

        case 'updCaserio':
          require_once 'chuquis/caserio/updCaserio.php';
          break;

          // chuquis-geografia
        case 'createGeografia':
          require_once 'chuquis/geografia/createGeografia.php';
          break;
          
        case 'readGeografia':
          require_once 'chuquis/geografia/readGeografia.php';
          break;

        case 'updateGeografia':
          require_once 'chuquis/geografia/updateGeografia.php';
          break;

        case 'updGeografia':
          require_once 'chuquis/geografia/updGeografia.php';
          break;

          // chuquis-carnavales
        case 'createCarnavales':
          require_once 'chuquis/carnavales/createCarnavales.php';
          break;
          
        case 'readCarnavales':
          require_once 'chuquis/carnavales/readCarnavales.php';
          break;

        case 'updateCarnavales':
          require_once 'chuquis/carnavales/updateCarnavales.php';
          break;

        case 'updCarnavales':
          require_once 'chuquis/carnavales/updCarnavales.php';
          break;
        
          // chuquis-sitiosArqueologicos
        case 'createSitiosarqueologicos':
          require_once 'chuquis/sitiosarqueologicos/createSitiosarqueologicos.php';
          break;
          
        case 'readSitiosarqueologicos':
          require_once 'chuquis/sitiosarqueologicos/readSitiosarqueologicos.php';
          break;

        case 'updateSitiosarqueologicos':
          require_once 'chuquis/sitiosarqueologicos/updateSitiosarqueologicos.php';
          break;

        case 'updSitiosarqueologicos':
          require_once 'chuquis/sitiosarqueologicos/updSitiosarqueologicos.php';
          break;

          //tingo Maria
        case 'readLugaresTuristicos':
          require_once 'tingomaria/lugaresTuristicos/readLugaresTuristicos.php';
          break;
        
        
        case 'createLugaresTuristicos':
          require_once 'tingomaria/lugaresTuristicos/createLugaresTuristicos.php';
          break;
        
        case 'updateLugaresTuristicos':
          require_once 'tingomaria/lugaresTuristicos/updateLugaresTuristicos.php';
          break;
        
        case 'updLugaresTuristicos':
          require_once 'tingomaria/lugaresTuristicos/updLugaresTuristicos.php';
          break;

          //blog
        case 'readBlog':
          require_once 'blog/readBlog.php';
          break;
        
        
        case 'createBlog':
          require_once 'blog/createBlog.php';
          break;
        
        case 'updateBlog':
          require_once 'blog/updateBlog.php';
          break;
        
        case 'updBlog':
          require_once 'blog/updBlog.php';
          break;
          //blog
        case 'readKuyaiki':
          require_once 'kuyaiki/readKuyaiki.php';
          break;
        
        
        case 'createKuyaiki':
          require_once 'kuyaiki/createKuyaiki.php';
          break;
        
        case 'updateKuyaiki':
          require_once 'kuyaiki/updateKuyaiki.php';
          break;
        
        case 'updKuyaiki':
          require_once 'kuyaiki/updKuyaiki.php';
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
