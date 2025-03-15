<?php include './header.php' ?>
<?php  
    // Okul adında eğer varsa başta ve sondaki boşlukları silme işlemi  
    $schoolName = trim($_GET["schoolName"]); 
    $schoolClassName = trim($_GET["schoolClassName"]); 
    // Her kelimenin ilk harfini büyük yapma
    $schoolClassName = mb_convert_case(ucwords_tr(strtolower_tr($schoolClassName)), MB_CASE_TITLE, "UTF-8");
?> 
<?php 


?>

<div class="container">
    <div class="row">
        <div class="col-12 pt-3 border-bottom border-start border-end">
            <p class="text-center fs-5 fw-bolder">SINIF EKLE > <?php echo $schoolClassName; ?></p>
        </div>
        <div class="col-12 border p-3">
            <?php 
                echo '<p><strong>Sınıf Eklenen Okul:</strong> '.$schoolName.'</p>';
                echo '<p><strong>Eklenen Sınıf:</strong> '.$schoolClassName.'</p>';
            ?>
            <?php sinifEkle ( $schoolName, $schoolClassName ); ?>
        </div>
    </div>
</div>
<?php include './footer.php';?>