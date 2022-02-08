<?php 


//traer datos de costumbres
$querySitiosarqueologicos = mysqli_query($cnx, "SELECT * FROM sitiosarqueologicos ORDER BY sitiosarqueologicos_id DESC");

//eliminar flora por id
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $cod = $_POST['sitiosarqueologicos_cod'];

    if($cod){
        // query para encontrar por cod
        $queryfloraByCod = mysqli_query($cnx, "SELECT * FROM sitiosarqueologicos WHERE sitiosarqueologicos_cod = '$cod'");
        $resultadoQueryByCod  = mysqli_fetch_assoc($queryfloraByCod);
        
        unlink('./mediaBD/mediaChuquis/sitiosarqueologicos/'.$resultadoQueryByCod['sitiosarqueologicos_foto']);


        $queryEliminar = mysqli_query($cnx, "DELETE FROM sitiosarqueologicos WHERE sitiosarqueologicos_cod = '$cod'");

        if($queryEliminar){
            header('Location:index.php?action=readSitiosarqueologicos&eliminado=1');
        }
    }
}

?>

<a class="read__add" href="index.php?action=createSitiosarqueologicos"><i class="fas fa-plus"></i>Agregar</a>
<a class="read__add" href="index.php?action=updSitiosarqueologicos"><i class="fas fa-cog"></i></a>
<section class="read">
<div class="header_fixed">
        <table>
            <h2 class="table__title">Sitios Arqueologicos</h2>
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Imagen</th>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Texto</th>
                    <th>Fecha</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
             <?php
             $query = $querySitiosarqueologicos;
             $tabla = [
                'cod'       => 'sitiosarqueologicos_cod',
                'nombre'    => 'sitiosarqueologicos_nombre',
                'texto'     => 'sitiosarqueologicos_texto',
                'foto'      => 'sitiosarqueologicos_foto',
                'fecha'     => 'sitiosarqueologicos_fecha',
             ];

             $ruta = 'sitiosarqueologicos';
             $rutaActualizar = 'updateSitiosarqueologicos&sitiosarqueologicosCod';
             $eliminar = 'sitiosarqueologicos_cod';
                // imprime tabla
                readChuquis($query,$tabla,$ruta,$rutaActualizar,$eliminar)
             ?>
                    
            </tbody>
        </table>

    </div>
    <?php
            $eliminado = $_GET['eliminado'] ?? null;
            if($eliminado == 1):
        ?>
            <span class="eliminado_success" >Eliminado Correctamente</span>
        <?php endif; ?>
</section>