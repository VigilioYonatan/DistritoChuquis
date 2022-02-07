<?php 


//traer datos de costumbres
$queryCostumbres = mysqli_query($cnx, "SELECT * FROM costumbre ORDER BY costumbre_id DESC");


//eliminar COstumbre por id
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $cod = $_POST['costumbre_cod'];

    if($cod){

        // query para encontrar por cod
        $queryCostumbreByCod = mysqli_query($cnx, "SELECT * FROM costumbre WHERE costumbre_cod = '$cod'");
        
        $resultadoQueryByCod  = mysqli_fetch_assoc($queryCostumbreByCod);
        
        unlink('./mediaBD/mediaChuquis/costumbres/'.$resultadoQueryByCod['costumbre_foto']);


        $queryEliminar = mysqli_query($cnx, "DELETE FROM costumbre WHERE costumbre_cod = '$cod'");

        if($queryEliminar){
            header('Location:index.php?action=readCostumbres&eliminado=1');
        }
    }
}

?>

<a class="read__add" href="index.php?action=createCostumbres"><i class="fas fa-plus"></i>Agregar</a>
<a class="read__add" href="index.php?action=updCostumbres"><i class="fas fa-cog"></i></a>
<section class="read">
<div class="header_fixed">
        <table>
            <h2 class="table__title">Costumbres</h2>
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
                    while($rowCostumbre = mysqli_fetch_assoc($queryCostumbres)):
                        $costrumbreCod = $rowCostumbre['costumbre_cod'];
                        $costrumbreNombre = $rowCostumbre['costumbre_nombre'];
                        $costrumbreTexto = $rowCostumbre['costumbre_texto'];
                        $costrumbreFoto = $rowCostumbre['costumbre_foto'];
                        $costrumbreFecha= $rowCostumbre['costumbre_fecha'];
                ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><img src="./mediaBD/mediaChuquis/costumbres/<?php echo $costrumbreFoto; ?>" /></td>
                    <td><?php echo $costrumbreCod; ?></td>
                    <td><?php echo $costrumbreNombre; ?></td>
                    <td><?php echo $costrumbreTexto; ?></td>
                    <td><?php echo $costrumbreFecha; ?></td>
                    <td class="table-btn">
                        <a href="index.php?action=updateCostumbres&costumbreCod=<?php echo $costrumbreCod; ?>" class="table-btn__upd"><i class="fas fa-pen-alt"></i>Actualizar</a>
                        <form action="" method="POST">
                            <input type="hidden" name="costumbre_cod" value="<?php echo $costrumbreCod; ?>">
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