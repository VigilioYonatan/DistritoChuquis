
   
<?php require_once './includes/header.php';

// query chuquis

$queryChuquis = mysqli_query($cnx, "SELECT * FROM chuquis LIMIT 8");

// query chuquis_tables by id most recent

$queryRecent = mysqli_query($cnx, "SELECT * FROM chuquis_tables ORDER BY id DESC LIMIT 6");


// query post reciente blog

$queryBlog = mysqli_query($cnx, "SELECT * FROM chuquis_tables WHERE ChuquisCod = 'BLOG' ORDER BY id DESC LIMIT 1");
$resultBlog = mysqli_fetch_assoc($queryBlog);

$nombreBlog = $resultBlog['nombre'];
$textoBlog = $resultBlog['texto'];
$fotoBlog = $resultBlog['foto'];
$fechaBlog = $resultBlog['fecha'];
$rutaBlog = $resultBlog['ruta'];


// query kuyaiki

$queryKuyaiki = mysqli_query($cnx, "SELECT * FROM chuquis_tables WHERE ChuquisCod = 'KUYAIKI' ORDER BY id DESC LIMIT 6");

?>
   <!-- wallpaper -->
    <section class="container-wallpaper" id="welcome">
        <video class="container-wallpaper__video" src="./admin/mediaBD/mediaInicio/<?php echo $inicioWallpaper; ?>" autoplay muted loop></video>
        <div class="wallpaper">
            <picture class="wallpaper-info">
                <img class="wallpaper-info__img" src="./admin/mediaBD/mediaInicio/<?php echo $inicioWelcome; ?>" alt="">
                <div class="wallpaper-info-text">
                    <h2 class="wallpaper-info-text__title">Bienvenido!</h2>
                    <h1 class="wallpaper-info-text__txt">Kuyaiki Photography</h1>
                </div>
            </picture>

            
            <article class="wallpaper-about">
                <div class="about">     
                    <h2 class="about__title">Blog Personal</h2>
                    <div class="about-new">
                        <img  class="about-new__img" src="./admin/mediaBD/<?php echo $rutaBlog; ?>/<?php echo $fotoBlog; ?>" alt="<?php echo $nombreBlog; ?>" title="<?php echo $nombreBlog; ?>">
                        <div class="about-new-info">
                            <span class="about-new-info__time">Fecha: <?php echo $fechaBlog; ?></span>
                            <h3 class="about-new-info__title"><?php echo $nombreBlog; ?></h3>
                            <p class="about-new-info__text">
                                <?php echo $textoBlog; ?>
                            </p>
                            <a class="about-new-info__btn" href="blog.php">Ver Más</a>
                        </div>
                    </div> 
               </div>
                </div>
            </article>
        </div>
        <div class="redes">
            <div class="redes-social">
                <?php redesSociales();?>
                
            </div>
        </div>
    </section>
    <!-- fin wallpaper -->

    <!-- post -->
    <section class="post-container" id="postRecientes">
        <span class="post__title">POST RECIENTES</span>
        <div class="post-images">
            <?php while ($rowRecent = mysqli_fetch_assoc($queryRecent)):
                        $recentNombre   =   $rowRecent['nombre'];
                        $recentTexto    =   $rowRecent['texto'];
                        $recentFoto     =   $rowRecent['foto'];
                        $recentRuta     =   $rowRecent['ruta'];
                        $recentCod    =   $rowRecent['cod'];
                 ?>
            <picture class="post-imagen animation-initial">
                <div class="post-imagen-img">
                    <img class="post-imagen-img__img" src="./admin/mediaBD/<?php echo $recentRuta; ?>/<?php echo $recentFoto; ?>" alt="">
                    <div class="background">
                        <p class="background__txt"><?php echo $recentTexto; ?></p>
                    </div>
                </div>        
                <span class="post-imagen__title"><?php echo $recentNombre; ?></span> 
            </picture>
            <?php endwhile; ?>
        </div>   
    </section>
    <!-- fin post -->

    <!-- distrito chuquis -->

    <section class="chuquis" id="chuquis">
        <h3 class="chuquis__title">Distrito de Chuquis - Huánuco</h3>
        <div class="chuquis-categoria">
            <div class="carousel__contenedor" >

				<div id="glider" class="carousel__lista">
                    <?php while ($row = mysqli_fetch_assoc($queryChuquis)):
                        $fotoChuquis = $row['chuquis_foto'];     
                        $nombreChuquis = $row['chuquis_nombre'];     
                        $textoChuquis = $row['chuquis_texto'];     
                        $videoChuquis = $row['chuquis_video'];     
                        $urlChuquis = $row['chuquis_url'];     
                    ?>
					<div class="carousel__elemento">
						<img src="./admin/mediaBD/mediaChuquis/chuquis/<?php echo $fotoChuquis; ?>" alt="<?php echo $nombreChuquis; ?>" title="Distrito de Chuquis - Huanuco" >
						<article class="carousel__parrafo">
                            <span class="carousel__title"><?php echo $nombreChuquis; ?></span>
                            <p class="carousel__text"><?php echo $textoChuquis; ?></p>
                            <a href="chuquis.php?action=<?php echo $urlChuquis; ?>" class="carousel__link">Ver Más</a>
                        </article>
					</div>
                    <?php endwhile; ?>
				</div>
				<button aria-label="Anterior" class="carousel__anterior"><svg class="btn__left" viewBox="0 0 512 512"><path  d="M256 504C119 504 8 393 8 256S119 8 256 8s248 111 248 248-111 248-248 248zm27.5-379.5l-123 123c-4.7 4.7-4.7 12.3 0 17l123 123c7.6 7.6 20.5 2.2 20.5-8.5V133c0-10.7-12.9-16.1-20.5-8.5z" class=""></path></svg></button>

				<button aria-label="Siguiente" class="carousel__siguiente">
					<svg class="btn__left" viewBox="0 0 512 512" ><path d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zm-27.5 379.5l123-123c4.7-4.7 4.7-12.3 0-17l-123-123c-7.6-7.6-20.5-2.2-20.5 8.5v246c0 10.7 12.9 16.1 20.5 8.5z" class=""></path></svg>
				</button>
			</div>
        </div>
    </section>
    <!-- fin distrito chuquis -->
<!-- kUYAIKI PHOTOGRAPHY -->
    <section class="post-container-kuyaiki" id="postRecientes">
        <span class="post__title">KUYAIKI PHOTOGRAPHY</span>
        <div class="post-images">
            <?php while ($rowKuyaiki= mysqli_fetch_assoc($queryKuyaiki)):
                        $kuyaikiNombre   =   $rowKuyaiki['nombre'];
                        $kuyaikiTexto    =   $rowKuyaiki['texto'];
                        $kuyaikiFoto     =   $rowKuyaiki['foto'];
                        $kuyaikiRuta     =   $rowKuyaiki['ruta'];
                        $kuyaikiCod    =   $rowKuyaiki['cod'];
                 ?>
            <picture class="post-imagen animation-initial">
                <div class="post-imagen-img">
                    <img class="post-imagen-img__img" src="./admin/mediaBD/<?php echo $kuyaikiRuta; ?>/<?php echo $kuyaikiFoto; ?>" alt="<?php echo $kuyaikiNombre; ?>" title='<?php echo $kuyaikiNombre; ?>'>
                    <div class="background">
                        <p class="background__txt"><?php echo $kuyaikiTexto; ?></p>
                    </div>
                </div>        
                <span class="post-imagen__title"><?php echo $kuyaikiNombre; ?></span> 
            </picture>
            <?php endwhile; ?>
        </div>   
    </section>
    <!-- fin post -->

<?php require_once './includes/footer.php'; ?>
