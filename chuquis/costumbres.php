<?php
    //paginador
    $queryPaginador = mysqli_query($cnx, "SELECT count(*) as total FROM costumbre" );
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
    $querycostumbre = mysqli_query($cnx, "SELECT * FROM costumbre ORDER BY costumbre_id DESC LIMIT $desde,$por_pagina");

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
    <h2 class="album__title">Costumbres</h2>
    <div class="album">
    <?php 
    $tabla =[
        'nombre' => 'costumbre_nombre',
        'texto'  => 'costumbre_texto',
        'foto'   => 'costumbre_foto',
        'fecha'  => 'costumbre_fecha'
    ];

    $ruta = 'costumbres';

    listChuquis($querycostumbre, $tabla, $ruta);
    ?>
    </div>
</section>
<!-- fin card -->
<!-- paginador -->
<div class="paginador-container">
        <ul class="paginador">
            <?php
            $url = 'costumbres';
             paginador($pagina, $totalPaginas,$url);
            ?>
        </ul>
    </div>
</div>