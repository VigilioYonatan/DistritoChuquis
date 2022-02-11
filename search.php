<?php require_once './includes/header.php';
    if(isset($_GET['search_text'])){
        $buscar = $_GET['search_text'];
        if(strlen($_GET['search_text']) === 0 ){
            header('Location:index.php');
        }
    }
    $busquedas = [];
    $querySearch = mysqli_query($cnx, "SELECT * FROM chuquis_tables where nombre LIKE '$buscar%' ");
   
?>

<section class="borrarPadding">
    <h2 class="album__title">Se encontró <?php  echo $querySearch -> num_rows; ?> resultados </h2>
    <div class="album">
    <?php if($querySearch -> num_rows === 0): ?>
        <img src="./build/img/empty_item.svg" height="500px" width="100%" alt="">

    <?php else: ?>
    <?php  while($rowSearch = mysqli_fetch_assoc($querySearch)):
    
        $nombre = $rowSearch['nombre'];
        $texto = $rowSearch['texto'];
        $foto = $rowSearch['foto'];
        $fecha = $rowSearch['fecha'];
        $ruta = $rowSearch['ruta'];
        ?>
        
        <picture class='album-card'>
                <img class='album-card__img' src='./admin/mediaBD/<?php echo $ruta; ?>/<?php echo $foto; ?>' alt='<?php echo $nombre; ?>' title='<?php echo $nombre; ?>'>
            <div class='card-info'>
                <h3 class='card-info__title'><?php echo $nombre; ?></h3>
                <p class='card-info__text'><?php echo $texto; ?></p>
            <span class='card-info__time'>Publicado: <b> <?php echo $fecha; ?></b></span>
            </div>
        </picture>
        <?php endwhile; ?>
    </div>
        <?php endif; ?>
    <!-- //si no se encontró resultados -->
    
</section>

<?php require_once './includes/footer.php';