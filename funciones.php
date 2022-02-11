<!-- funciones -->
<?php 

//redes Sociales

function redesSociales(){
    global $inicioFacebook, $inicioWhatsapp, $inicioYoutube;

    echo "<a href='$inicioFacebook' target='_blank' rel='nofollow' class='redes-social__link'><i class='fab fa-facebook redes-social__ico'></i></a>
    <a href='$inicioWhatsapp' target='_blank' rel='nofollow' class='redes-social__link'><i class='fab fa-whatsapp redes-social__ico'></i></i></a>
    <a href='$inicioYoutube'  target='_blank' rel='nofollow' class='redes-social__link'><i class='fab fa-youtube redes-social__ico'></i></i></i></a>";
}
//lista de imagenes chuquis
function listChuquis($query){
    while($row = mysqli_fetch_assoc($query)):
        $nombre     = $row[ 'nombre' ];
        $texto      = $row[ 'texto' ];
        $foto       = $row[ 'foto' ];
        $fecha      = $row[ 'fecha' ];
        $ruta      = $row[ 'ruta' ];

        echo    "<picture class='album-card animation-initial-showUp'>
                    <img class='album-card__img' src='./admin/mediaBD/$ruta/$foto' alt='$nombre' title='$nombre'>
                    <div class='card-info'>
                        <h3 class='card-info__title'>$nombre</h3>
                        <p class='card-info__text'>$texto</p>
                        <span class='card-info__time'>Publicado: <b>$fecha</b></span>
                    </div>
                </picture>";

    endwhile;
}



// paginador

function paginador($pagina, $totalPaginas,$url){
    $paginasPrevious = $pagina-1;
    if($pagina != 1): 
        echo "<li class='paginador__list'><a href='$url&pagina=1'><i class='fas fa-fast-backward'></i></a></li>
        <li class='paginador__list'><a href='$url&pagina=$paginasPrevious'><i class='fas fa-step-backward'></i></a></li";
    endif;
 
        for ($i=1; $i <= $totalPaginas ; $i++) { 
            if($i == $pagina){
                echo "<li class='paginador__list paginador__list--stop'>$i</li>";
            }else{
                echo "<li class='paginador__list' ><a href='$url&pagina=$i'>$i</a></li>";
            }
        }
    $paginasNext = $pagina+1;
    if($pagina != $totalPaginas):
        echo "  <li class='paginador__list'><a href='$url&$paginasNext'><i class='fas fa-step-forward'></i></a></li>
                <li class='paginador__list'><a href='$url&pagina=$paginasNext'><i class='fas fa-fast-forward'></i></a></li>";
    endif;
}


function destacado($codigo){
      // foto destacada
      global $cnx;

      $queryCarnavalesBY = mysqli_query($cnx, "SELECT * FROM chuquis_tables WHERE ChuquisCod = '$codigo' AND destacado = 1");
      $rowDestacado = mysqli_fetch_assoc($queryCarnavalesBY);
  
      $rowNombre = $rowDestacado['nombre'];
      $rowTexto = $rowDestacado['texto'];
      $rowFoto = $rowDestacado['foto'];
      $rowFecha = $rowDestacado['fecha'];
      $rowRuta = $rowDestacado['ruta'];

      echo " <div class='about-new'>
                <img  class='about-new__img' src='./admin/mediaBD/$rowRuta/$rowFoto' alt='$rowNombre' title='$rowNombre'>
                <div class='about-new-info'>
                    <span class='about-new-info__time'>$rowFecha</span>
                    <h3 class='about-new-info__title'>$rowNombre</h3>
                    <p class='about-new-info__text'>$rowTexto</p>
                </div>
            </div> ";
}