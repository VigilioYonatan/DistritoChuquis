
   
<?php require_once './includes/header.php';



//query INicio
$queryInicio = mysqli_query($cnx, "SELECT * FROM inicio");
$resultadoQuery = mysqli_fetch_assoc($queryInicio);

$inicioWelcome = $resultadoQuery['inicio_welcomeFoto'];
$inicioWallpaper = $resultadoQuery['inicio_welcomeWallpaper'];
$inicioFacebook = $resultadoQuery['inicio_facebook'];
$inicioWhatsapp = $resultadoQuery['inicio_whatsapp'];
$inicioYoutube = $resultadoQuery['inicio_youtube'];

?>
   <!-- wallpaper -->
    <section class="container-wallpaper" id="welcome">
        <div class="container-wallpaper__background"></div>
        <video class="container-wallpaper__video" src="./admin/mediaBD/mediaInicio/<?php echo $inicioWallpaper; ?>" autoplay muted loop></video>
        <div class="wallpaper">
            <picture class="wallpaper-info">
                <img class="wallpaper-info__img" src="./admin/mediaBD/mediaInicio/<?php echo $inicioWelcome; ?>" alt="">
                <div class="wallpaper-info-text">
                    <h2 class="wallpaper-info-text__title">Welcome!</h2>
                    <span class="wallpaper-info-text__txt">Join my Journey</span>
                </div>
            </picture>
            <article class="wallpaper-about">
                <div class="about">     
                    <h2 class="about__title">Featured Post</h2>
                    <div class="about-new">
                        <img  class="about-new__img" src="./build/img/bernaportada.webp" alt="">
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
                <a href="<?php echo $inicioFacebook; ?>" target="_blank" class="redes-social__link"><i class="fab fa-facebook redes-social__ico"></i></a>
                <a href="<?php echo $inicioWhatsapp; ?>" target="_blank" class="redes-social__link"><i class="fab fa-whatsapp redes-social__ico"></i></i></a>
                <a href="<?php echo $inicioYoutube; ?>"  target="_blank" class="redes-social__link"><i class="fab fa-youtube redes-social__ico"></i></i></i></a>
            </div>
        </div>
    </section>
    <!-- fin wallpaper -->

    <!-- post -->
    <section class="post-container" id="postRecientes">
        <span class="post__title">Post Recientes</span>
        <div class="post-images">
            <picture class="post-imagen">
                <div class="post-imagen-img">
                    <img class="post-imagen-img__img" src="./build/img/paisaje1.webp" alt="">
                    <div class="background">
                        <p class="background__txt">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi explicabo aperiam voluptatibus, facere cumque, rerum necessitatibus molestias quos tenetur magni laboriosam, ipsum dicta. Ipsum natus aperiam blanditiis perspiciatis voluptatibus vitae.</p>
                    </div>
                </div>        
                <span class="post-imagen__title">Mexico: A Culinary Journey</span> 
            </picture>
            <picture class="post-imagen">
                <div class="post-imagen-img">
                    <img class="post-imagen-img__img" src="./build/img/paisaje2.webp" alt="">
                    <div class="background">
                        <p class="background__txt">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi explicabo aperiam voluptatibus, facere cumque, rerum necessitatibus molestias quos tenetur magni laboriosam, ipsum dicta. Ipsum natus aperiam blanditiis perspiciatis voluptatibus vitae.</p>
                    </div>
                </div>        
                <span class="post-imagen__title">Mexico: A Culinary Journey</span> 
            </picture>
            <picture class="post-imagen">
                <div class="post-imagen-img">
                    <img class="post-imagen-img__img" src="./build/img/paisaje3.webp" alt="">
                    <div class="background">
                        <p class="background__txt">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi explicabo aperiam voluptatibus, facere cumque, rerum necessitatibus molestias quos tenetur magni laboriosam, ipsum dicta. Ipsum natus aperiam blanditiis perspiciatis voluptatibus vitae.</p>
                    </div>
                </div>        
                <span class="post-imagen__title">Mexico: A Culinary Journey</span> 
            </picture>
            <picture class="post-imagen">
                <div class="post-imagen-img">
                    <img class="post-imagen-img__img" src="./build/img/paisaje4.webp" alt="">
                    <div class="background">
                        <p class="background__txt">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi explicabo aperiam voluptatibus, facere cumque, rerum necessitatibus molestias quos tenetur magni laboriosam, ipsum dicta. Ipsum natus aperiam blanditiis perspiciatis voluptatibus vitae.</p>
                    </div>
                </div>        
                <span class="post-imagen__title">Mexico: A Culinary Journey</span> 
            </picture>
            <picture class="post-imagen">
                <div class="post-imagen-img">
                    <img class="post-imagen-img__img" src="./build/img/paisaje5.webp" alt="">
                    <div class="background">
                        <p class="background__txt">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi explicabo aperiam voluptatibus, facere cumque, rerum necessitatibus molestias quos tenetur magni laboriosam, ipsum dicta. Ipsum natus aperiam blanditiis perspiciatis voluptatibus vitae.</p>
                    </div>
                </div>        
                <span class="post-imagen__title">Mexico: A Culinary Journey</span> 
            </picture>
            <picture class="post-imagen">
                <div class="post-imagen-img">
                    <img class="post-imagen-img__img" src="./build/img//paisaje6.webp" alt="">
                    <div class="background">
                        <p class="background__txt">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi explicabo aperiam voluptatibus, facere cumque, rerum necessitatibus molestias quos tenetur magni laboriosam, ipsum dicta. Ipsum natus aperiam blanditiis perspiciatis voluptatibus vitae.</p>
                    </div>
                </div>        
                <span class="post-imagen__title">Mexico: A Culinary Journey</span> 
            </picture>
        </div>   
    </section>
    <!-- fin post -->

    <!-- distrito chuquis -->

    <section class="chuquis" id="chuquis">
        <h3 class="chuquis__title">Distrito de Chuquis</h3>
        <div class="chuquis-categoria">
            <div class="carousel__contenedor" >

				<div id="glider" class="carousel__lista">
					<div class="carousel__elemento">
						<img src="./build/img/paisaje1.webp" alt="Rock and Roll Hall of Fame">
						<article class="carousel__parrafo">
                            <span class="carousel__title">Geografia</span>
                            <p class="carousel__text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat, quisquam? Eligendi asperiores voluptas </p>
                            <a href="#" class="carousel__link">Ver Más</a>
                        </article>
					</div>
					
					
				</div>
				<button aria-label="Anterior" class="carousel__anterior"><svg class="btn__left" viewBox="0 0 512 512"><path  d="M256 504C119 504 8 393 8 256S119 8 256 8s248 111 248 248-111 248-248 248zm27.5-379.5l-123 123c-4.7 4.7-4.7 12.3 0 17l123 123c7.6 7.6 20.5 2.2 20.5-8.5V133c0-10.7-12.9-16.1-20.5-8.5z" class=""></path></svg></button>

				<button aria-label="Siguiente" class="carousel__siguiente">
					<svg class="btn__left" viewBox="0 0 512 512" ><path d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zm-27.5 379.5l123-123c4.7-4.7 4.7-12.3 0-17l-123-123c-7.6-7.6-20.5-2.2-20.5 8.5v246c0 10.7 12.9 16.1 20.5 8.5z" class=""></path></svg>
				</button>
			</div>
        </div>
    </section>
    <!-- fin distrito chuquis -->
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<?php require_once './includes/footer.php'; ?>
