<?php require_once './includes/header.php'; 
require_once 'funciones.php';


if(isset($_GET['action'])){
        $action = $_GET['action'];
      }else{
        $action = '';
      }

      switch ($action) {
        case 'costumbres':
          require_once './chuquis/costumbres.php';
          break;
        case 'flora':
          require_once './chuquis/flora.php';
          break;
        case 'fauna':
          require_once './chuquis/fauna.php';
          break;
        case 'turismo':
          require_once './chuquis/turismo.php';
          break;
    
        case 'caserios':
          require_once './chuquis/caserios.php';
          break;

        case 'geografia':
          require_once './chuquis/geografia.php';
          break;

        case 'carnavales':
          require_once './chuquis/carnavales.php';
          break;
    
        case 'sitiosarqueologicos':
          require_once './chuquis/sitiosarqueologicos.php';
          break;
    
        
        default:
          # code...
          break;
      }
      ?>

 <?php require_once './includes/footer.php' ?>