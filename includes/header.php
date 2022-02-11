<?php require_once './includes/db.php';
require_once './funciones.php';
session_start();

//query INicio
$queryInicio = mysqli_query($cnx, "SELECT * FROM inicio");
$resultadoQuery = mysqli_fetch_assoc($queryInicio);

$inicioWelcome = $resultadoQuery['inicio_welcomeFoto'];
$inicioWallpaper = $resultadoQuery['inicio_welcomeWallpaper'];
$inicioFacebook = $resultadoQuery['inicio_facebook'];
$inicioWhatsapp = $resultadoQuery['inicio_whatsapp'];
$inicioYoutube = $resultadoQuery['inicio_youtube'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="language" content="spanish">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php
    $costumbres = $_GET['action'] ?? null;
    ?>
    <title>
        <?php echo $costumbres == 'costumbres' ? 'costumbres Distrito de Chuquis' : ''; ?>
        <?php echo $costumbres == 'fauna' ? 'Fauna Distrito de Chuquis' : ''; ?>
        <?php echo $costumbres == 'turismo' ? 'Turismo Distrito de Chuquis' : ''; ?>
        <?php echo $costumbres == 'caserios' ? 'Caserios Distrito de Chuquis' : ''; ?>
        <?php echo $costumbres == 'geografia' ? 'Geografía Distrito de Chuquis' : ''; ?>
        <?php echo $costumbres == 'carnavales' ? 'Carnavales Distrito de Chuquis' : ''; ?>
        <?php echo $costumbres == 'sitiosarqueologicos' ? 'Sitios Arqueologicos Distrito de Chuquis' : ''; ?>
        <?php echo $costumbres == 'flora' ? 'Flora Distrito de Chuquis' : ''; ?>
        <?php echo $costumbres == 'lugaresTuristicos' ? 'Tingo Maria lugares Turisticos' : ''; ?>
        <?php echo !$costumbres ? 'Kuyaiki Photgraphy' : ''; ?>
    </title>
    <meta name="copyright" content="Kuyaiki Photography Perú">
    <meta name="descripcion" content="Kuyaiki Photography ">
    <meta name="keywords" content="Fotografias,Kuyaiki, San francisco de Casha, 2 de Mayo,Tingo Maria,Distrito de Chuquis,HUANUCO,PERÚ">
    <meta name="author" content="Bernardo Justo Vigilio">
    <meta name="audience" content="all">
    <meta name="robots" content="index, all, follow">
    <meta name="Category" content="fotografías">
    <meta itemprop="telephone" content="+51 931 030 149">
    <link rel="icon" type="image/png" href="./build/img/logoIco.webp"/>
    <link rel="stylesheet" href="./build/css/app.css?<?php  echo date('s');?>">

</head>
<body>
    <!-- header -->
    <header class="header">
        <!-- navbar -->
        <nav class="navbar">
            <a href="index.php" class="navbar-logo"><img class="navbar-logo__img" src="./build/img/logo.webp" alt="Kuyaiki Photography" title="Kuyaiki Fotografía"></a>
            <form class="navbar-search" method="GET" action="search.php">
                <input class="navbar-search__input" type="text" placeholder="Buscar" name="search_text">
                <button><i  class="fas fa-search navbar-search__ico "></i></button>
            </form>
            <ul class="navbar-menu">
                <li class="navbar-menu-list"><a class="navbar-menu-list__link" href="index.php">Inicio</a></li>
                <li class="navbar-menu-list navbar-menu-list-linked" id="distritoChuquis"><span class="navbar-menu-list__link" href="">Distrito de Chuquis</span>
                    <ul class="navbar-menu-list-submenu">
                        <li class="navbar-menu-list-submenu-list"><a class="navbar-menu-list-submenu-list__link" href="chuquis.php?action=costumbres">Costumbres</a></li>
                        <li class="navbar-menu-list-submenu-list"><a class="navbar-menu-list-submenu-list__link" href="chuquis.php?action=flora">Flora</a></li>
                        <li class="navbar-menu-list-submenu-list"><a class="navbar-menu-list-submenu-list__link" href="chuquis.php?action=fauna">Fauna</a></li>
                        <li class="navbar-menu-list-submenu-list"><a class="navbar-menu-list-submenu-list__link" href="chuquis.php?action=turismo">Turísmo</a></li>
                        <li class="navbar-menu-list-submenu-list"><a class="navbar-menu-list-submenu-list__link" href="chuquis.php?action=caserios">Caserios</a></li>
                        <li class="navbar-menu-list-submenu-list"><a class="navbar-menu-list-submenu-list__link" href="chuquis.php?action=geografia">Geografia</a></li>
                        <li class="navbar-menu-list-submenu-list"><a class="navbar-menu-list-submenu-list__link" href="chuquis.php?action=carnavales">Carnavales</a></li>
                        <li class="navbar-menu-list-submenu-list"><a class="navbar-menu-list-submenu-list__link" href="chuquis.php?action=sitiosarqueologicos">Sitios Arquelógicos</a></li>                      
                    </ul>
                </li>
                <li class="navbar-menu-list navbar-menu-list-linked" id="tingomaria"><span  class="navbar-menu-list__link" >Tingo Maria</span>
                    <ul class="navbar-menu-list-submenu less">
                            <li class="navbar-menu-list-submenu-list" ><a class="navbar-menu-list-submenu-list__link" href="tingomaria.php?action=lugaresTuristicos">Lugares Turísticos</a></li>
                     </ul>
                </li>
              
                <li class="navbar-menu-list"><a  class="navbar-menu-list__link" href="blog.php">Blog Personal</a></li>
                <li class="navbar-menu-list"><a  class="navbar-menu-list__link" href="kuyaiki.php">Kuyaiki Photography</a></li>
                <!-- <li class="navbar-menu-list"><a  class="navbar-menu-list__link" href="">Soporte</a></li> -->
            </ul>
            <button class="navbar-responsive" id="menu-hamburguer"><i class="fas fa-bars navbar-responsive__ico"></i></button>
        </nav>
        <!-- fin navbar -->
        
    </header>
    <!-- fin header -->