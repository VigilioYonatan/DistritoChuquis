<?php
    //paginador
    $queryPaginador = mysqli_query($cnx, "SELECT count(*) as total FROM chuquis_tables WHERE ChuquisCod = 'CHU-CAR'" );
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
    if(isset($_GET['pagina']) && $_GET['pagina'] > $totalPaginas ){
        header('Location: index.php');
    }

     //imagenes costumbre
    $querycarnavales = mysqli_query($cnx, "SELECT * FROM chuquis_tables WHERE ChuquisCod = 'CHU-CAR' ORDER BY id DESC LIMIT $desde,$por_pagina");

    // wallpaper costumbres
    $carnavales = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'CHU-CAR'");
    $resultadocarnavales = mysqli_fetch_assoc($carnavales);

    $carnavalesNombre = $resultadocarnavales['chuquis_nombre'];
    $carnavalesFoto = $resultadocarnavales['chuquis_foto'];
    $carnavalesVideo = $resultadocarnavales['chuquis_video'];
?>
    
<!-- wallpaper -->
<?php if(!isset($_GET['pagina']) || $_GET['pagina'] < 2): ?>

<section class="container-wallpaper" id="welcome">
        <div class="container-wallpaper__background"></div>
    <video class="container-wallpaper__video" src="./admin/mediaBD/mediaChuquis/chuquis/<?php echo $carnavalesVideo; ?>" autoplay muted loop></video>
    <div class="wallpaper">
        <picture class="wallpaper-info">
            <img class="wallpaper-info__img" src="./admin/mediaBD/mediaChuquis/chuquis/<?php echo $carnavalesFoto; ?>" alt="<?php echo $carnavalesNombre; ?>">
            <div class="wallpaper-info-text">
                <h2 class="wallpaper-info-text__title">Bienvenido!</h2>
                <span class="wallpaper-info-text__txt"><?php echo $carnavalesNombre; ?></span>
            </div>
        </picture>
        <article class="wallpaper-about">
            <div class="about">     
                <h2 class="about__title">Fotografía Destacada</h2>
                <?php    // foto destacada
                $codigo = 'CHU-CAR';
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
    <h2 class="album__title">Carnavales</h2>
    <div class="album">
    <?php 
 
    listChuquis($querycarnavales);
    ?>
    </div>
</section>
<!-- fin card -->
<!-- paginador -->
<div class="paginador-container">
        <ul class="paginador">
        <?php
            $url = 'chuquis.php?action=carnavales';
             paginador($pagina, $totalPaginas,$url);
            ?>
        </ul>
    </div>
</div>