<?php 


//traer datos de costumbres
$queryFlora = mysqli_query($cnx, "SELECT * FROM flora ORDER BY flora_id DESC");


//eliminar flora por id
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $cod = $_POST['flora_cod'];

    if($cod){

        // query para encontrar por cod
        $queryfloraByCod = mysqli_query($cnx, "SELECT * FROM flora WHERE flora_cod = '$cod'");
        
        $resultadoQueryByCod  = mysqli_fetch_assoc($queryfloraByCod);
        
        unlink('./mediaBD/mediaChuquis/flora/'.$resultadoQueryByCod['flora_foto']);


        $queryEliminar = mysqli_query($cnx, "DELETE FROM flora WHERE flora_cod = '$cod'");

        if($queryEliminar){
            header('Location:index.php?action=readFlora&eliminado=1');
        }
    }
}

?>

<a class="read__add" href="index.php?action=createFlora"><i class="fas fa-plus"></i>Agregar</a>
<a class="read__add" href="index.php?action=updFlora"><i class="fas fa-cog"></i></a>
<section class="read">
<div class="header_fixed">
        <table>
            <h2 class="table__title">Flora</h2>
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
                    $i = 1;
                    while($rowFlora = mysqli_fetch_assoc($queryFlora)):
                        $floraCod = $rowFlora['flora_cod'];
                        $floraNombre = $rowFlora['flora_nombre'];
                        $floraTexto = $rowFlora['flora_texto'];
                        $floraFoto = $rowFlora['flora_foto'];
                        $floraFecha= $rowFlora['flora_fecha'];
                ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><img src="./mediaBD/mediaChuquis/flora/<?php echo $floraFoto; ?>" /></td>
                    <td><?php echo $floraCod; ?></td>
                    <td><?php echo $floraNombre; ?></td>
                    <td><?php echo $floraTexto; ?></td>
                    <td><?php echo $floraFecha; ?></td>
                    <td class="table-btn">
                        <a href="index.php?action=updateFlora&floraCod=<?php echo $floraCod; ?>" class="table-btn__upd"><i class="fas fa-pen-alt"></i>Actualizar</a>
                        <form action="" method="POST">
                            <input type="hidden" name="flora_cod" value="<?php echo $floraCod; ?>">
                            <button  class="table-btn__del"><i class="fas fa-trash"></i>Eliminar</button>
                           
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
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