<?php
    //paginador
    $queryPaginador = mysqli_query($cnx, "SELECT count(*) as total FROM chuquis_tables WHERE ChuquisCod = 'CHU-STA'" );
    $resultadoPaginador = mysqli_fetch_assoc($queryPaginador);

    $total = $resultadoPaginador['total'];

    $por_pagina = 12;
    

    if(empty($_GET['pagina'])){
        $pagina = 1;
    }else{
        $pagina = $_GET['pagina'];
    }

    $desde = ($pagina - 1) * $por_pagina;

    if(isset($_GET['pagina']) && $_GET['pagina'] > $totalPaginas ){
        header('Location: index.php');
    }

    $totalPaginas = ceil($total / $por_pagina); // total de paginas que habrá en el paginador
    // //imagenes costumbre
    $querysitiosarqueologicos = mysqli_query($cnx, "SELECT * FROM chuquis_tables WHERE ChuquisCod = 'CHU-STA' ORDER BY id DESC LIMIT $desde,$por_pagina");

    // wallpaper costumbres
    $sitiosarqueologicos = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'CHU-STA'");
    $resultadositiosarqueologicos = mysqli_fetch_assoc($sitiosarqueologicos);

    $sitiosarqueologicosNombre = $resultadositiosarqueologicos['chuquis_nombre'];
    $sitiosarqueologicosFoto = $resultadositiosarqueologicos['chuquis_foto'];
    $sitiosarqueologicosVideo = $resultadositiosarqueologicos['chuquis_video'];
?>
    
<!-- wallpaper -->
<?php if(!isset($_GET['pagina']) || $_GET['pagina'] < 2): ?>

<section class="container-wallpaper" id="welcome">
        <div class="container-wallpaper__background"></div>
    <video class="container-wallpaper__video" src="./admin/mediaBD/mediaChuquis/chuquis/<?php echo $sitiosarqueologicosVideo; ?>" autoplay muted loop></video>
    <div class="wallpaper">
        <picture class="wallpaper-info">
            <img class="wallpaper-info__img" src="./admin/mediaBD/mediaChuquis/chuquis/<?php echo $sitiosarqueologicosFoto; ?>" alt="">
            <div class="wallpaper-info-text">
                <h2 class="wallpaper-info-text__title">Bienvenido!</h2>
                <span class="wallpaper-info-text__txt"><?php echo $sitiosarqueologicosNombre; ?></span>
            </div>
        </picture>
        <article class="wallpaper-about">
            <div class="about">     
                <h2 class="about__title">Fotografía Destacada</h2>
                <?php    // foto destacada
                    $codigo = 'CHU-STA';
                    destacado($codigo)
                ?>
            </div>
        </article>
    </div>
    <div class="redes">
        <div class="redes-social">
            <?php redesSociales();?>
        </div>
    </div>
</section>
<?php endif; ?>
<!-- fin wallpaper -->
<!-- card -->
<section class="<?php echo isset($_GET['pagina']) && $_GET['pagina'] >= 2 ? 'borrarPadding' : 'album-container '; ?>">
    <h2 class="album__title">Sitios Arqueológicos</h2>
    <div class="album">
    <?php 
    listChuquis($querysitiosarqueologicos);
    ?>
    </div>
</section>
<!-- fin card -->
<!-- paginador -->
<div class="paginador-container">
        <ul class="paginador">
        <?php
            $url = 'chuquis.php?action=sitiosarqueologicos';
             paginador($pagina, $totalPaginas,$url);
            ?>
        </ul>
    </div>
</div>