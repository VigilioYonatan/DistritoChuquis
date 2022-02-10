<?php require_once './includes/header.php';
require_once './funciones.php';

$queryWalppaper = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'BLOG'");
$resultadoBlog = mysqli_fetch_assoc($queryWalppaper);

$blogVideo = $resultadoBlog['chuquis_video'];
$blogNombre = $resultadoBlog['chuquis_nombre'];
$blogTexto= $resultadoBlog['chuquis_texto'];

//paginador
$queryPaginador = mysqli_query($cnx, "SELECT count(*) as total FROM chuquis_tables WHERE ChuquisCod = 'BLOG'");
$resultadoPaginador = mysqli_fetch_assoc($queryPaginador);

$total = $resultadoPaginador['total'];

$por_pagina = 12;


if(empty($_GET['pagina'])){
    $pagina = 1;
}else{
    $pagina = $_GET['pagina'];
}

$desde = ($pagina - 1) * $por_pagina;

// if(isset($_GET['pagina']) && $_GET['pagina'] > $totalPaginas ){
//     header('Location: index.php');
// }

$totalPaginas = ceil($total / $por_pagina); // total de paginas que habrá en el paginador
// //imagenes costumbre
$queryblog = mysqli_query($cnx, "SELECT * FROM chuquis_tables WHERE ChuquisCod = 'BLOG' ORDER BY id DESC LIMIT $desde,$por_pagina");
?>
<?php if(!isset($_GET['pagina']) || $_GET['pagina'] == 1): ?>
<section class="blog-wallpaper">
    <video class="blog-img" src="./admin/mediaBD/mediaChuquis/chuquis/<?php echo $blogVideo; ?>" loop autoplay muted ></video>
    <img class="blog-img-hidden" src="./build/img/FONDO BLANCO-min.png" alt="">
    <div class="blog-wallpaper-text">
        <h2 class="blog-wallpaper-text__title"><?php echo $blogNombre; ?></h2>
        <p class="blog-wallpaper-text__text"><?php echo $blogTexto; ?></p>
    </div>

</section>

<?php  endif; ?>
<section class="<?php echo isset($_GET['pagina']) && $_GET['pagina'] >= 2 ? 'borrarCard' : 'blog-container '; ?>">
    <?php if(!isset($_GET['pagina']) || $_GET['pagina'] == 1): ?>
    <div class="blog-title">
        <h2 class="blog-title__titulo">Find your Experience</h2>
        <p class="blog-title__text">
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestiae error sit, sequi sint voluptatum deserunt eius facere eveniet tenetur ducimus obcaecati optio est eum porro aut natus fugit incidunt vero!
        </p>
    </div>
    <?php endif; ?>
    <div class="photos">

        <?php while($rowBlog = mysqli_fetch_assoc($queryblog)):
            $blogTexto = $rowBlog['texto'];
            $blogFoto = $rowBlog['foto'];
        ?>
        <picture class="photos-card">
            <img class="photos-card__img" src="./admin/mediaBD/mediaBlog/<?php echo $blogFoto; ?>" alt="">
            <article class="photos-text">
                <p class="photos-text__texto"> <?php echo $blogTexto; ?></p>
            </article>
        </picture>
       <?php endwhile; ?>
    </div>
</section>
<!-- paginador -->
<div class="paginador-container">
        <ul class="paginador">
        <?php
            $url = 'blog.php?next';
             paginador($pagina, $totalPaginas,$url);
            ?>
        </ul>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>