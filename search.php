<?php require_once './includes/header.php';?>
<?php
    //paginador
    $queryPaginador = mysqli_query($cnx, "SELECT count(*) as total FROM turismo" );
    $resultadoPaginador = mysqli_fetch_assoc($queryPaginador);

    $total = $resultadoPaginador['total'];

    $por_pagina = 6;
    

    if(empty($_GET['pagina'])){
        $pagina = 1;
    }else{
        $pagina = $_GET['pagina'];
    }

    $desde = ($pagina - 1) * $por_pagina;

    $totalPaginas = ceil($total / $por_pagina); // total de paginas que habrá en el paginador
    // //imagenes costumbre
    $queryturismo = mysqli_query($cnx, "SELECT * FROM turismo ORDER BY turismo_id DESC LIMIT $desde,$por_pagina");

    // wallpaper costumbres
    $turismo = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'CHU-TUR'");
    $resultadoturismo = mysqli_fetch_assoc($turismo);

    $turismoNombre = $resultadoturismo['chuquis_nombre'];
    $turismoFoto = $resultadoturismo['chuquis_foto'];
    $turismoVideo = $resultadoturismo['chuquis_video'];
?>
    
<!-- card -->
<section class="<?php echo $_GET['pagina'] >= 2 ? 'borrarPadding' : 'album-container '; ?>">
    <h2 class="album__title">Turismo</h2>
    <div class="album">
    <?php 
    $tabla =[
        'nombre' => 'turismo_nombre',
        'texto'  => 'turismo_texto',
        'foto'   => 'turismo_foto',
        'fecha'  => 'turismo_fecha'
    ];

    $ruta = 'turismo';

    listChuquis($queryturismo, $tabla, $ruta);
    ?>
    </div>
</section>
<!-- fin card -->
<!-- paginador -->
<div class="paginador-container">
        <ul class="paginador">
        <?php if($pagina != 1): ?>
            <li class='paginador__list'><a href="chuquis.php?action=turismo&pagina=1"><i class="fas fa-fast-backward"></i></a></li>
            <li class='paginador__list'><a href="chuquis.php?action=turismo&pagina=<?php echo $pagina-1; ?>"><i class="fas fa-step-backward"></i></a></li>
        <?php endif; ?>
         <?php 
            for ($i=1; $i <= $totalPaginas ; $i++) { 
                if($i == $pagina){
                    echo "<li class='paginador__list paginador__list--stop'>$i</li>";
                }else{
                    echo "<li class='paginador__list' ><a href='chuquis.php?action=turismo&pagina=$i'>$i</a></li>";
                }
            }
        ?>
            
        <?php  if($pagina != $totalPaginas):?>
            <li class='paginador__list'><a href="chuquis.php?action=turismo&pagina=<?php echo $pagina+1; ?>"><i class="fas fa-step-forward"></i></a></li>
            <li class='paginador__list'><a href="chuquis.php?action=turismo&pagina=<?php echo $totalPaginas; ?>"><i class="fas fa-fast-forward"></i></a></li>
        <?php endif; ?>
        </ul>
    </div>
</div>
<?php require_once './includes/footer.php';