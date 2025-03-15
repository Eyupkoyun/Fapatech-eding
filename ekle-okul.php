<?php include './header.php'; ?>
<?php  
    // Okul adında eğer varsa başta ve sondaki boşlukları silme işlemi  
    $schoolName = trim($_GET["schoolName"]); 
    // Her kelimenin ilk harfini büyük yapma
    $schoolName = mb_convert_case(ucwords_tr(strtolower_tr($schoolName)), MB_CASE_TITLE, "UTF-8");
?> 
<?php 


?>

<div class="container">
    <div class="row">
        <div class="col-12 pt-3 border-bottom border-start border-end">
            <p class="text-center fs-5 fw-bolder">OKUL EKLE > <?php echo $schoolName; ?></p>
        </div>
        <div class="col-12 border p-3">
            <?php 
                echo '<p><strong>Eklenen Okul:</strong> '.$schoolName.'</p>';
            ?>
            <?php okulEkle ( $schoolName ); ?>
        </div>
    </div>
</div>
<?php include './footer.php';?>