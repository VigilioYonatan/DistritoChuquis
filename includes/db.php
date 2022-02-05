<?php

$cnx = mysqli_connect('localhost', 'VIGILIO98', 'vigilio98', 'kuyaiki');

if(mysqli_connect_errno($cnx)){
    echo 'Error en conectar a la base de datos'.mysqli_connect_error();
}

mysqli_query($cnx, "SET NAMES 'utf8'");