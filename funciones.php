<!-- funciones -->
<?php 
//lista de imagenes chuquis
function listChuquis($query, $tabla,$ruta){
    while($row = mysqli_fetch_assoc($query)):
        $nombre    = $row[ $tabla['nombre'] ];
        $texto = $row[ $tabla['texto'] ];
        $foto  = $row[ $tabla['foto'] ];
        $fecha   = $row[ $tabla['fecha'] ];

        echo    "<picture class='album-card'>
                    <img class='album-card__img' src='./admin/mediaBD/mediaChuquis/$ruta/$foto' alt='$nombre' title='$nombre'>
                    <div class='card-info'>
                        <h3 class='card-info__title'>$nombre</h3>
                        <p class='card-info__text'>$texto</p>
                        <span class='card-info__time'>Publicado: <b>$fecha</b></span>
                    </div>
                </picture>";

    endwhile;
}