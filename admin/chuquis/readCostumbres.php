<?php 


//traer datos de costumbres

$queryCostumbres = mysqli_query($cnx, "SELECT * FROM costumbre");

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
                    <td class="table-btn"><a href="index.php?action=updateCostumbres&costumbreCod=<?php echo $costrumbreCod; ?>" class="table-btn__upd"><i class="fas fa-pen-alt"></i>Actualizar</a><a href="" class="table-btn__del"><i class="fas fa-trash"></i>Eliminar</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</section>