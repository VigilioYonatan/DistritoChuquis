<?php require_once './includes/header.php';


    // wallpaper blogs
    $blog = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'BLOG'");
    $resultadoblog = mysqli_fetch_assoc($blog);

    $blogNombre = $resultadoblog['chuquis_nombre'];
    $blogFoto = $resultadoblog['chuquis_foto'];
    $blogVideo = $resultadoblog['chuquis_video'];
    $blogTexto = $resultadoblog['chuquis_texto'];
?>
<section class="blog-wallpaper">
    <img class="blog-img" src="./admin/mediaBD/mediaChuquis/chuquis/<?php echo $blogVideo; ?>" alt="" >
    <img class="blog-img-hidden" src="./build//img/FONDO BLANCO-min.png" alt="">
    <div class="blog-wallpaper-text">
        <h2 class="blog-wallpaper-text__title"><?php echo $blogNombre; ?></h2>
        <p class="blog-wallpaper-text__text"><?php echo $blogTexto; ?></p>
    </div>

</section>
<section class="blog-container">
    <div class="blog-title">
        <h2 class="blog-title__titulo">Find your Experience</h2>
        <p class="blog-title__text">
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestiae error sit, sequi sint voluptatum deserunt eius facere eveniet tenetur ducimus obcaecati optio est eum porro aut natus fugit incidunt vero!
        </p>
    </div>
    <div class="photos">
        <picture class="photos-card">
            <img class="photos-card__img" src="./pexels-nandhu-kumar-339614.jpg" alt="">
            <article class="photos-text">
                <p class="photos-text__texto">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci voluptatum recusandae qui, minima laudantium doloremque libero maiores facilis optio atque eveniet harum quas. Minus tempore voluptas id, vel dolore odit.</p>
            </article>
        </picture>
        <picture class="photos-card">
            <img class="photos-card__img" src="./build/img/danzaHuanuco.webp" alt="">
            <article class="photos-text">
                <p class="photos-text__texto">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci voluptatum recusandae qui, minima laudantium doloremque libero maiores facilis optio atque eveniet harum quas. Minus tempore voluptas id, vel dolore odit.</p>
            </article>
        </picture>
        <picture class="photos-card">
            <img class="photos-card__img" src="./pexels-nandhu-kumar-339614.jpg" alt="">
            <article class="photos-text">
                <p class="photos-text__texto">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci voluptatum recusandae qui, minima laudantium doloremque libero maiores facilis optio atque eveniet harum quas. Minus tempore voluptas id, vel dolore odit.</p>
            </article>
        </picture>
        <picture class="photos-card">
            <img class="photos-card__img" src="./pexels-nandhu-kumar-339614.jpg" alt="">
            <article class="photos-text">
                <p class="photos-text__texto">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci voluptatum recusandae qui, minima laudantium doloremque libero maiores facilis optio atque eveniet harum quas. Minus tempore voluptas id, vel dolore odit.</p>
            </article>
        </picture>
        <picture class="photos-card">
            <img class="photos-card__img" src="./pexels-nandhu-kumar-339614.jpg" alt="">
            <article class="photos-text">
                <p class="photos-text__texto">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci voluptatum recusandae qui, minima laudantium doloremque libero maiores facilis optio atque eveniet harum quas. Minus tempore voluptas id, vel dolore odit.</p>
            </article>
        </picture>
        <picture class="photos-card">
            <img class="photos-card__img" src="./pexels-nandhu-kumar-339614.jpg" alt="">
            <article class="photos-text">
                <p class="photos-text__texto">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci voluptatum recusandae qui, minima laudantium doloremque libero maiores facilis optio atque eveniet harum quas. Minus tempore voluptas id, vel dolore odit.</p>
            </article>
        </picture>
        <picture class="photos-card">
            <img class="photos-card__img" src="./pexels-nandhu-kumar-339614.jpg" alt="">
            <article class="photos-text">
                <p class="photos-text__texto">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci voluptatum recusandae qui, minima laudantium doloremque libero maiores facilis optio atque eveniet harum quas. Minus tempore voluptas id, vel dolore odit.</p>
            </article>
        </picture>
        <picture class="photos-card">
            <img class="photos-card__img" src="./pexels-nandhu-kumar-339614.jpg" alt="">
            <article class="photos-text">
                <p class="photos-text__texto">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci voluptatum recusandae qui, minima laudantium doloremque libero maiores facilis optio atque eveniet harum quas. Minus tempore voluptas id, vel dolore odit.</p>
            </article>
        </picture>
        <picture class="photos-card">
            <img class="photos-card__img" src="./pexels-nandhu-kumar-339614.jpg" alt="">
            <article class="photos-text">
                <p class="photos-text__texto">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci voluptatum recusandae qui, minima laudantium doloremque libero maiores facilis optio atque eveniet harum quas. Minus tempore voluptas id, vel dolore odit.</p>
            </article>
        </picture>
        <picture class="photos-card">
            <img class="photos-card__img" src="./pexels-nandhu-kumar-339614.jpg" alt="">
            <article class="photos-text">
                <p class="photos-text__texto">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci voluptatum recusandae qui, minima laudantium doloremque libero maiores facilis optio atque eveniet harum quas. Minus tempore voluptas id, vel dolore odit.</p>
            </article>
        </picture>
        <picture class="photos-card">
            <img class="photos-card__img" src="./pexels-nandhu-kumar-339614.jpg" alt="">
            <article class="photos-text">
                <p class="photos-text__texto">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci voluptatum recusandae qui, minima laudantium doloremque libero maiores facilis optio atque eveniet harum quas. Minus tempore voluptas id, vel dolore odit.</p>
            </article>
        </picture>
        <picture class="photos-card">
            <img class="photos-card__img" src="./pexels-nandhu-kumar-339614.jpg" alt="">
            <article class="photos-text">
                <p class="photos-text__texto">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci voluptatum recusandae qui, minima laudantium doloremque libero maiores facilis optio atque eveniet harum quas. Minus tempore voluptas id, vel dolore odit.</p>
            </article>
        </picture>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>