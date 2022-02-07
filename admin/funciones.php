<?php

require_once '../includes/db.php';
// Validaciones
function validarFormulario($errores,$nombre, $texto, $foto, $upd = false){
    global $cnx;

    $errores =[];

    $Nombre = $nombre; 
    $Texto =  $texto; 
    $Foto = $foto;


    if(!$Nombre){
        $errores['nombreVacio'] = 'El nombre no debe estar Vacio';
    }

    if(strlen($Nombre) > 50){
        $errores['nombreLargo'] = 'Nombre demasiado Largo max 50';
    }

    if(!$Texto){
        $errores['textoVacio'] = 'El texto no debe estar vacio';
    }

    if($Foto['size'] > 5000000){
        $errores['fotoPesado'] = 'Imagen Muy pesado, menos de 5MB';
    }


    if($upd){
        if( $Foto['type'] !== 'image/jpeg' && $Foto['type'] !== 'image/jpg' && $Foto['type'] !== 'image/png' && $Foto['type'] !== 'image/webp' && !$Foto['error']){
            $errores['fotoNoDisponible'] = 'Insertar Imagen obligatoriamente en formato imagen';
        }
    
    }else{
        if( $Foto['type'] !== 'image/jpeg' && $Foto['type'] !== 'image/jpg' && $Foto['type'] !== 'image/png' && $Foto['type'] !== 'image/webp'){
            $errores['fotoNoDisponible'] = 'Insertar Imagen obligatoriamente en formato imagen';
        }
    }
    

  

    return $errores;

}


// read Chuquis 

function readChuquis($query,$tabla,$ruta,$rutaActualizar,$eliminar){
    $i = 0;
    while($row = mysqli_fetch_assoc($query)):
        $cod    = $row[ $tabla['cod'] ];
        $nombre = $row[ $tabla['nombre'] ];
        $texto  = $row[ $tabla['texto'] ];
        $foto   = $row[ $tabla['foto'] ];
        $fecha  = $row[ $tabla['fecha'] ];
        $i++;
        echo "<tr>
                <td>$i</td>
                <td><img src='./mediaBD/mediaChuquis/$ruta/$foto'/></td>
                <td>$cod</td>
                <td>$nombre</td>
                <td>$texto</td>
                <td>$fecha</td>
                <td class='table-btn'>
                    <a href='index.php?action=$rutaActualizar=$cod' class='table-btn__upd'><i class='fas fa-pen-alt'></i>Actualizar</a>
                    <form action='' method='POST'>
                        <input type='hidden' name='$eliminar' value='$cod'>
                        <button  class='table-btn__del'><i class='fas fa-trash'></i>Eliminar</button>
                    </form>
                </td>
                </tr>";

    endwhile;
}


// validacion wallpaper welcome

function validarFormularioWelcome($errores, $welcome, $wallpaper){
    $errores = [];
    if($welcome['size'] > 2000000){
        $errores['fotoPesado'] = 'Imagen Muy pesado, max de 2MB';
    }

    if( $welcome['type'] !== 'image/jpeg' && $welcome['type'] !== 'image/jpg' && $welcome['type'] !== 'image/png' && $welcome['type'] !== 'image/webp' && !$welcome['error']){
        $errores['fotoNoDisponible'] = 'Imagen no disponible, Solo formatos imagenes';
    }

    
    if($wallpaper['size'] > 40000000){
        $errores['videoPesado'] = 'Video muy pesado, max de 40MB';
    }

    if( $wallpaper['type'] !== 'video/mp4' && !$wallpaper['error']){
        $errores['videoNoDisponible'] = 'Video no disponible, Solo MP4';
    }

    return $errores;

}
