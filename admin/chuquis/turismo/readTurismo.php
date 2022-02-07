<?php 


//traer datos de costumbres
$queryTurismo = mysqli_query($cnx, "SELECT * FROM turismo ORDER BY turismo_id DESC");

//eliminar flora por id
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $cod = $_POST['turismo_cod'];

    if($cod){
        // query para encontrar por cod
        $queryfloraByCod = mysqli_query($cnx, "SELECT * FROM turismo WHERE turismo_cod = '$cod'");
        $resultadoQueryByCod  = mysqli_fetch_assoc($queryfloraByCod);
        
        unlink('./mediaBD/mediaChuquis/turismo/'.$resultadoQueryByCod['turismo_foto']);


        $queryEliminar = mysqli_query($cnx, "DELETE FROM turismo WHERE turismo_cod = '$cod'");

        if($queryEliminar){
            header('Location:index.php?action=readTurismo&eliminado=1');
        }
    }
}

?>

<a class="read__add" href="index.php?action=createTurismo"><i class="fas fa-plus"></i>Agregar</a>
<a class="read__add" href="index.php?action=updTurismo"><i class="fas fa-cog"></i></a>
<section class="read">
<div class="header_fixed">
        <table>
            <h2 class="table__title">Turismo</h2>
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
             $query = $queryTurismo;
             $tabla = [
                'cod'       => 'turismo_cod',
                'nombre'    => 'turismo_nombre',
                'texto'     => 'turismo_texto',
                'foto'      => 'turismo_foto',
                'fecha'     => 'turismo_fecha',
             ];

             $ruta = 'turismo';
             $rutaActualizar = 'updateTurismo&turismoCod';
             $eliminar = 'turismo_cod';
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