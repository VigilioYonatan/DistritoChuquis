<?php
    //paginador
    $queryPaginador = mysqli_query($cnx, "SELECT count(*) as total FROM chuquis_tables WHERE ChuquisCod = 'CHU-COS'" );
    $resultadoPaginador = mysqli_fetch_assoc($queryPaginador);

    $total = $resultadoPaginador['total'];

    $por_pagina = 12;
    

    if(empty($_GET['pagina'])){
        $pagina = 1;
    }else{
        $pagina = $_GET['pagina'];
    }

    $desde = ($pagina - 1) * $por_pagina;

    $totalPaginas = ceil($total / $por_pagina); // total de paginas que habrá en el paginador
    
    if(isset($_GET['pagina']) && $_GET['pagina'] > $totalPaginas ){ //  por si alguien pone la url paginas demas que no existan
        header('Location: index.php');
    }

    // //imagenes costumbre
    $querycostumbre = mysqli_query($cnx, "SELECT * FROM chuquis_tables WHERE ChuquisCod = 'CHU-COS' ORDER BY id DESC LIMIT $desde,$por_pagina");

    // wallpaper costumbres
    $costumbre = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'CHU-COS'");
    $resultadocostumbre = mysqli_fetch_assoc($costumbre);

    $costumbreNombre = $resultadocostumbre['chuquis_nombre'];
    $costumbreFoto = $resultadocostumbre['chuquis_foto'];
    $costumbreVideo = $resultadocostumbre['chuquis_video'];
?>
    
<!-- wallpaper -->
<?php if(!isset($_GET['pagina']) || $_GET['pagina'] < 2): ?>

<section class="container-wallpaper" id="welcome">
        <div class="container-wallpaper__background"></div>
    <video class="container-wallpaper__video" src="./admin/mediaBD/mediaChuquis/chuquis/<?php echo $costumbreVideo; ?>" autoplay muted loop></video>
    <div class="wallpaper">
        <picture class="wallpaper-info">
            <img class="wallpaper-info__img" src="./admin/mediaBD/mediaChuquis/chuquis/<?php echo $costumbreFoto; ?>" alt="">
            <div class="wallpaper-info-text">
                <h2 class="wallpaper-info-text__title">Bienvenido!</h2>
                <span class="wallpaper-info-text__txt"><?php echo $costumbreNombre; ?></span>
            </div>
        </picture>
        <article class="wallpaper-about">
            <div class="about">     
                <h2 class="about__title">Fotografía Destacada</h2>
                <?php    // foto destacada
                    $codigo = 'CHU-COS';
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
    <h2 class="album__title">Costumbres</h2>
    <div class="album">
    <?php 
    listChuquis($querycostumbre);
    ?>
    </div>
</section>
<!-- fin card -->
<!-- paginador -->
<div class="paginador-container">
        <ul class="paginador">
            <?php
            $url = 'chuquis.php?action=costumbres';
             paginador($pagina, $totalPaginas,$url);
            ?>
        </ul>
    </div>
</div>