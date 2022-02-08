<?php require_once './includes/db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distrito De Chuquis</title>
    <link rel="icon" type="image/png" href="./build/img/logo.webp"/>
    <link rel="stylesheet" href="./build/css/app.css?<?php  echo date('s');?>">
</head>
<body>
    <!-- header -->
    <header class="header">
        <!-- navbar -->
        <nav class="navbar">
            <a href="index.php" class="navbar-logo"><img class="navbar-logo__img" src="./build/img/logo.webp" alt=""></a>
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
                <li class="navbar-menu-list"><a  class="navbar-menu-list__link"href="">Tingo Maria</a></li>
                <li class="navbar-menu-list"><a  class="navbar-menu-list__link"href="">Blog Personal</a></li>
                <li class="navbar-menu-list"><a  class="navbar-menu-list__link"href="">Kuyaiki Photography</a></li>
                <li class="navbar-menu-list"><a  class="navbar-menu-list__link"href="">Soporte</a></li>
            </ul>
            <button class="navbar-responsive" id="menu-hamburguer"><i class="fas fa-bars navbar-responsive__ico"></i></button>
        </nav>
        <!-- fin navbar -->
        
    </header>
    <!-- fin header -->