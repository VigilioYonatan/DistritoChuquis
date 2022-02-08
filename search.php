<?php require_once './includes/header.php';
    if(isset($_GET['search_text'])){
        $buscar = $_GET['search_text'];
        if(strlen($_GET['search_text']) === 0 ){
            header('Location:index.php');
        }
    }
    $busquedas = [];
    $querySearch = mysqli_query($cnx, "SELECT * FROM costumbre where costumbre_nombre LIKE '%$buscar%' ");
    var_dump($querySearch);
?>
<section class="borrarPadding">
    <h2 class="album__title">Se encontró <?php  echo $querySearch -> num_rows; ?> resultados </h2>
    <div class="album">
    <?php  while($rowSearch = mysqli_fetch_assoc($querySearch)):
    
        $nombre = $rowSearch['costumbre_nombre'];
        $texto = $rowSearch['costumbre_texto'];
        $foto = $rowSearch['costumbre_foto'];
        $fecha = $rowSearch['costumbre_fecha'];
        ?>
        
        <picture class='album-card'>
                <img class='album-card__img' src='./admin/mediaBD/mediaChuquis/costumbres/<?php echo $foto; ?>' alt='<?php echo $nombre; ?>' title='<?php echo $nombre; ?>'>
            <div class='card-info'>
                <h3 class='card-info__title'><?php echo $nombre; ?></h3>
                <p class='card-info__text'><?php echo $texto; ?></p>
            <span class='card-info__time'>Publicado: <b> <?php echo $fecha; ?></b></span>
            </div>
        </picture>
        <?php endwhile; ?>
    </div>
</section>

<?php require_once './includes/footer.php';