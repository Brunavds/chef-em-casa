<?php 
$currentPage = 'Index';
include_once(__DIR__ .'./components/header.php');
?>


<main class="container bg-info">
    <h1>Página Inicial</h1>

    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
        <img src="img2/10.png" class="d-block w-100" alt="Comida1">
    </div>
    <div class="carousel-item">
      <img src="img2/13.png" class="d-block w-100" alt="Comida2">
    </div>
    <div class="carousel-item">
      <img src="img2/15.png" class="d-block w-100" alt="Comida3">
    </div>
  </div>
</div>
</main>  

<?php 
include_once( __DIR__.'./components/footer.php');
?>
