<?php require_once './includes/header.php'; 
if(isset($_GET['action'])){
        $action = $_GET['action'];
      }else{
        $action = '';
      }

      switch ($action) {
        case 'costumbres':
          require_once './chuquis/costumbres.php';
          break;
    
        
        default:
          # code...
          break;
      }



 require_once './includes/footer.php' ?>;