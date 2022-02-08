<!-- funciones -->
<?php 
//lista de imagenes chuquis
function listChuquis($query, $tabla,$ruta){
    while($row = mysqli_fetch_assoc($query)):
        $nombre    = $row[ $tabla['nombre'] ];
        $texto = $row[ $tabla['texto'] ];
        $foto  = $row[ $tabla['foto'] ];
        $fecha   = $row[ $tabla['fecha'] ];

        echo    "<picture class='album-card animation-initial-showUp'>
                    <img class='album-card__img' src='./admin/mediaBD/mediaChuquis/$ruta/$foto' alt='$nombre' title='$nombre'>
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
        echo "<li class='paginador__list'><a href='chuquis.php?action=$url&pagina=1'><i class='fas fa-fast-backward'></i></a></li>
        <li class='paginador__list'><a href='chuquis.php?action=$url&pagina=$paginasPrevious'><i class='fas fa-step-backward'></i></a></li";
    endif;
 
        for ($i=1; $i <= $totalPaginas ; $i++) { 
            if($i == $pagina){
                echo "<li class='paginador__list paginador__list--stop'>$i</li>";
            }else{
                echo "<li class='paginador__list' ><a href='chuquis.php?action=$url&pagina=$i'>$i</a></li>";
            }
        }
    $paginasNext = $pagina+1;
    if($pagina != $totalPaginas):
        echo "  <li class='paginador__list'><a href='chuquis.php?action=$url&$paginasNext'><i class='fas fa-step-forward'></i></a></li>
                <li class='paginador__list'><a href='chuquis.php?action=$url&$totalPaginas'><i class='fas fa-fast-forward'></i></a></li>";
    endif;
}