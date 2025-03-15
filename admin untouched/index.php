<?php include_once 'template/header.php'; ?>


  <!-- Preloader 
    <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> 
  -->

  <?php include_once 'template/navbar.php'; ?>
  <?php include_once 'template/sidebar.php'; ?>

  <div class="container">
  <?php 
  if(isset($_GET['route'])) { //get metodu varsa . isset: yakala demek// root üzerinden istek gelmişse

    $pages= 'pages/'.strtolower($_GET['route']).'.php'; //pages içerisind eböyle sayfa varsa
  }  else { $pages= null; }
  
  if(file_exists ($pages)) {
    include_once $pages;
  } else {  include_once 'pages/index.php'; }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  ?>
  </div>
  

  <?php include_once 'template/footer.php'; ?>