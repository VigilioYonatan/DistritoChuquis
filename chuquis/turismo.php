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
    
<!-- wallpaper -->
<?php if(!isset($_GET['pagina']) || $_GET['pagina'] < 2): ?>

<section class="container-wallpaper" id="welcome">
        <div class="container-wallpaper__background"></div>
    <video class="container-wallpaper__video" src="./admin/mediaBD/mediaChuquis/turismo/<?php echo $turismoVideo; ?>" autoplay muted loop></video>
    <div class="wallpaper">
        <picture class="wallpaper-info">
            <img class="wallpaper-info__img" src="./admin/mediaBD/mediaChuquis/turismo/<?php echo $turismoFoto; ?>" alt="">
            <div class="wallpaper-info-text">
                <h2 class="wallpaper-info-text__title">Bienvenido!</h2>
                <span class="wallpaper-info-text__txt"><?php echo $turismoNombre; ?></span>
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