<?php
    //paginador
    $queryPaginador = mysqli_query($cnx, "SELECT count(*) as total FROM fauna" );
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
    $queryfauna = mysqli_query($cnx, "SELECT * FROM fauna ORDER BY fauna_id DESC LIMIT $desde,$por_pagina");

    // wallpaper costumbres
    $fauna = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'CHU-FAU'");
    $resultadofauna = mysqli_fetch_assoc($fauna);

    $faunaNombre = $resultadofauna['chuquis_nombre'];
    $faunaFoto = $resultadofauna['chuquis_foto'];
    $faunaVideo = $resultadofauna['chuquis_video'];
?>
    
<!-- wallpaper -->
<?php if(!isset($_GET['pagina']) || $_GET['pagina'] < 2): ?>

<section class="container-wallpaper" id="welcome">
        <div class="container-wallpaper__background"></div>
    <video class="container-wallpaper__video" src="./admin/mediaBD/mediaChuquis/chuquis/<?php echo $faunaVideo; ?>" autoplay muted loop></video>
    <div class="wallpaper">
        <picture class="wallpaper-info">
            <img class="wallpaper-info__img" src="./admin/mediaBD/mediaChuquis/chuquis/<?php echo $faunaFoto; ?>" alt="">
            <div class="wallpaper-info-text">
                <h2 class="wallpaper-info-text__title">Bienvenido!</h2>
                <span class="wallpaper-info-text__txt"><?php echo $faunaNombre; ?></span>
            </div>
        </picture>
        <article class="wallpaper-about">
            <div class="about">     
                <h2 class="about__title">Imagen Destacado</h2>
                <div class="about-new">
                    <img  class="about-new__img" src="./build/img/danzaHuanuco.webp" alt="">
                    <div class="about-new-info">
                        <span class="about-new-info__time">Dec 15, 2021 2min</span>
                        <h3 class="about-new-info__title">Top Hikes In Australia</h3>
                        <p class="about-new-info__text">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea earum voluptas, iste debitis molestias dolorum iure doloribus aspernatur, nisi aperiam placeat facere est soluta unde, ipsa recusandae voluptate optio assumenda.
                        </p>
                        <a class="about-new-info__btn" href="">Ver Más</a>
                    </div>
                </div> 
            </div>
            </div>
        </article>
    </div>
    <div class="redes">
        <div class="redes-social">
            <a href="#" class="redes-social__link"><i class="fab fa-facebook redes-social__ico"></i></a>
            <a href="#" class="redes-social__link"><i class="fab fa-whatsapp redes-social__ico"></i></i></a>
            <a href="#" class="redes-social__link"><i class="fab fa-youtube redes-social__ico"></i></i></i></a>
        </div>
    </div>
</section>
<?php endif; ?>
<!-- fin wallpaper -->
<!-- card -->
<section class="<?php echo isset($_GET['pagina']) && $_GET['pagina'] >= 2 ? 'borrarPadding' : 'album-container '; ?>">
    <h2 class="album__title">Fauna</h2>
    <div class="album">
    <?php 
    $tabla =[
        'nombre' => 'fauna_nombre',
        'texto'  => 'fauna_texto',
        'foto'   => 'fauna_foto',
        'fecha'  => 'fauna_fecha'
    ];

    $ruta = 'fauna';

    listChuquis($queryfauna, $tabla, $ruta);
    ?>
    </div>
</section>
<!-- fin card -->
<!-- paginador -->
<div class="paginador-container">
        <ul class="paginador">
        <?php
            $url = 'paginador';
             paginador($pagina, $totalPaginas,$url);
            ?>
        </ul>
    </div>
</div>