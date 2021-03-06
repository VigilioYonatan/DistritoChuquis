<?php require_once './includes/header.php';
require_once './funciones.php';

$queryWalppaper = mysqli_query($cnx, "SELECT * FROM chuquis WHERE chuquis_cod = 'KUYAIKI'");
$resultadoKuyaiki = mysqli_fetch_assoc($queryWalppaper);

$kuyaikiVideo = $resultadoKuyaiki['chuquis_video'];
$kuyaikiNombre = $resultadoKuyaiki['chuquis_nombre'];
$kuyaikiTexto= $resultadoKuyaiki['chuquis_texto'];

//paginador
$queryPaginador = mysqli_query($cnx, "SELECT count(*) as total FROM chuquis_tables WHERE ChuquisCod = 'KUYAIKI'");
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
$querykuyaiki = mysqli_query($cnx, "SELECT * FROM chuquis_tables WHERE ChuquisCod = 'KUYAIKI' ORDER BY id DESC LIMIT $desde,$por_pagina");
?>
<?php if(!isset($_GET['pagina']) || $_GET['pagina'] == 1): ?>
<section class="blog-wallpaper" id="welcome">
    <video class="blog-img" src="./admin/mediaBD/mediaChuquis/chuquis/<?php echo $kuyaikiVideo; ?>" loop autoplay muted ></video>
    <img class="blog-img-hidden" src="./build/img/portadakuyak.webp" alt="Kuyaiki Photography" title="Fotografias Kuyaiki">
    <div class="blog-wallpaper-text">
        <h2 class="blog-wallpaper-text__title"><?php echo $kuyaikiNombre; ?></h2>
        <h1 class="blog-wallpaper-text__text"><?php echo $kuyaikiTexto; ?></h1>
    </div>

</section>

<?php  endif; ?>
<section class="<?php echo isset($_GET['pagina']) && $_GET['pagina'] >= 2 ? 'borrarCard' : 'blog-container '; ?>">
    <?php if(!isset($_GET['pagina']) || $_GET['pagina'] == 1): ?>
    <div class="blog-title">
        <h2 class="blog-title__titulo">"Quiero hacer retratos tan intensos como las personas"</h2>
        <p class="blog-title__text">La fotografía ha sido tan importante en la historia mundial ,que tambien dejó huella no solo a través de imagenes sino tambien de palabras.
        Por eso en <b> KUYAIKI PHOTOGRAPHY</b> se pretende expresar mendiante las fotos las escencia del retoque fotográfico y inspirar tu artista interior.
        </p>
    </div>
    <?php endif; ?>
    <div class="photos">

        <?php while($rowKuyaiki = mysqli_fetch_assoc($querykuyaiki)):
            $kuyaikiTexto = $rowKuyaiki['texto'];
            $kuyaikiFoto = $rowKuyaiki['foto'];
        ?>
        <picture class="photos-card">
            <img class="photos-card__img" src="./admin/mediaBD/mediaKuyaiki/<?php echo $kuyaikiFoto; ?>" alt="Kuyaiki Photography Perú" title="Bernardo Justo Vigilio">
            <article class="photos-text">
                <p class="photos-text__texto"> <?php echo $kuyaikiTexto; ?></p>
            </article>
        </picture>
       <?php endwhile; ?>
    </div>
</section>
<!-- paginador -->
<div class="paginador-container">
        <ul class="paginador">
        <?php
            $url = 'kuyaiki.php?next';
             paginador($pagina, $totalPaginas,$url);
            ?>
        </ul>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>