<?php
    //paginador
    $queryPaginador = mysqli_query($cnx, "SELECT count(*) as total FROM chuquis_tables WHERE ChuquisCod = 'CHU-CAS'" );
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
    $querycaserio = mysqli_query($cnx, "SELECT * FROM chuquis_tables WHERE ChuquisCod = 'CHU-CAS' ORDER BY id DESC LIMIT $desde,$por_pagina");

    // wallpaper costumbres
    $caserio = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'CHU-CAS'");
    $resultadocaserio = mysqli_fetch_assoc($caserio);

    $caserioNombre = $resultadocaserio['chuquis_nombre'];
    $caserioFoto = $resultadocaserio['chuquis_foto'];
    $caserioVideo = $resultadocaserio['chuquis_video'];
?>
    
<!-- wallpaper -->
<?php if(!isset($_GET['pagina']) || $_GET['pagina'] < 2): ?>

<section class="container-wallpaper" id="welcome">
        <div class="container-wallpaper__background"></div>
    <video class="container-wallpaper__video" src="./admin/mediaBD/mediaChuquis/chuquis/<?php echo $caserioVideo; ?>" autoplay muted loop></video>
    <div class="wallpaper">
        <picture class="wallpaper-info">
            <img class="wallpaper-info__img" src="./admin/mediaBD/mediaChuquis/chuquis/<?php echo $caserioFoto; ?>" alt="<?php echo $caserioNombre; ?>">
            <div class="wallpaper-info-text">
                <h2 class="wallpaper-info-text__title">Bienvenido!</h2>
                <span class="wallpaper-info-text__txt"><?php echo $caserioNombre; ?></span>
            </div>
        </picture>
        <article class="wallpaper-about">
            <div class="about">     
                <h2 class="about__title">Fotografía Destacada</h2>
                <?php    // foto destacada
                    $codigo = 'CHU-CAS';
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
    <h2 class="album__title">Caserios</h2>
    <div class="album">
    <?php 

    listChuquis($querycaserio);
    ?>
    </div>
</section>
<!-- fin card -->
<!-- paginador -->
<div class="paginador-container">
        <ul class="paginador">
        <?php
            $url = 'chuquis.php?action=caserios';
             paginador($pagina, $totalPaginas,$url);
            ?>
        </ul>
    </div>
</div>