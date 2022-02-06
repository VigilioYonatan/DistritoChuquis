<?php
    //imagenes costumbre
    $queryCostumbres = mysqli_query($cnx, "SELECT * FROM costumbre");

    // wallpaper costumbres
    $costumbres = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'CHU-COD'");
    $resultadoCostumbre = mysqli_fetch_assoc($costumbres);

    $costumbreNombre = $resultadoCostumbre['chuquis_nombre'];
    $costumbreFoto = $resultadoCostumbre['chuquis_foto'];
    $costumbreVideo = $resultadoCostumbre['chuquis_video'];
?>
    
<!-- wallpaper -->
<section class="container-wallpaper" id="welcome">
        <div class="container-wallpaper__background"></div>
    <video class="container-wallpaper__video" src="./admin/mediaBD/mediaChuquis/costumbres/<?php echo $costumbreVideo; ?>" autoplay muted loop></video>
    <div class="wallpaper">
        <picture class="wallpaper-info">
            <img class="wallpaper-info__img" src="./admin/mediaBD/mediaChuquis/costumbres/<?php echo $costumbreFoto; ?>" alt="">
            <div class="wallpaper-info-text">
                <h2 class="wallpaper-info-text__title">Welcome!</h2>
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
<!-- fin wallpaper -->
<!-- card -->
<section class="album-container">
    <h2 class="album__title">Costumbres</h2>
    <div class="album">

    <?php while($rowCostumbres =  mysqli_fetch_assoc($queryCostumbres)):
            $costumbreNombre  = $rowCostumbres['costumbre_nombre'];
            $costumbreTexto  = $rowCostumbres['costumbre_texto'];
            $costumbreFoto  = $rowCostumbres['costumbre_foto'];
            $costumbreFecha  = $rowCostumbres['costumbre_fecha'];
        ?>
        <picture class="album-card">
            <img class="album-card__img" src="./admin/mediaBD/mediaChuquis/costumbres/<?php  echo $costumbreFoto;?>" alt="">
            <div class="card-info">
                <h3 class="card-info__title"><?php echo $costumbreNombre; ?></h3>
                <p class="card-info__text"><?php echo $costumbreTexto; ?></p>
                <span class="card-info__time">Publicado: <b><?php echo $costumbreFecha; ?></b></span>
            </div>
        </picture>
        <?php endwhile; ?>
    </div>
</section>
<!-- fin card -->
<!-- paginador -->
<div class="paginador-container">
    <div class="paginador">

    </div>
</div>