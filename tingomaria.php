<?php require_once './includes/header.php'; 
require_once 'funciones.php';


if(isset($_GET['action'])){
        $action = $_GET['action'];
      }else{
        $action = '';
      }

      switch ($action) {
        case 'lugaresTuristicos':
          require_once './tingomaria/lugaresTuristicos.php';
          break;

        default:
          # code...
          break;
      }
      ?>

 <?php require_once './includes/footer.php' ?>