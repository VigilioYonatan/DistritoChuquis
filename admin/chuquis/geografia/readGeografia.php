<?php 


//traer datos de costumbres
$queryGeografia = mysqli_query($cnx, "SELECT * FROM chuquis_tables WHERE ChuquisCod = 'CHU-GEO' ORDER BY id DESC");

//eliminar flora por id
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $cod = $_POST['geografia_cod'];

    if($cod){
        // query para encontrar por cod
        $queryfloraByCod = mysqli_query($cnx, "SELECT * FROM chuquis_tables WHERE cod = '$cod'");
        $resultadoQueryByCod  = mysqli_fetch_assoc($queryfloraByCod);
        
        unlink('./mediaBD/mediaChuquis/geografia/'.$resultadoQueryByCod['foto']);


        $queryEliminar = mysqli_query($cnx, "DELETE FROM chuquis_tables WHERE cod = '$cod'");

        if($queryEliminar){
            header('Location:index.php?action=readGeografia&eliminado=1');
        }
    }
}

?>

<a class="read__add" href="index.php?action=createGeografia"><i class="fas fa-plus"></i>Agregar</a>
<a class="read__add" href="index.php?action=updGeografia"><i class="fas fa-cog"></i></a>
<a class="read__add" href="index.php?action=destacadoGeografia"><i class="fas fa-star"></i></a>
<section class="read">
<div class="header_fixed">
        <table>
            <h2 class="table__title">Geografia</h2>
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
             $query = $queryGeografia;
             $ruta = 'mediaChuquis/geografia';
             $rutaActualizar = 'updateGeografia&geografiaCod';
             $eliminar = 'geografia_cod';
                // imprime tabla
                readChuquis($query,$ruta,$rutaActualizar,$eliminar)
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