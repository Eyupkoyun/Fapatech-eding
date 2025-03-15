<?php include './header.php'; ?>
<?php

    $counter = 1; $i = 0; // Sayici ve index başlangıç değer atamaları
    while( $counter < 101 ){ // 100 sinifa kadar kontrol eder.
        if( isset( $_GET["course-$counter"] ) ){
            $courses[$i] = $_GET["course-$counter"];
            $i++;
        }
        $counter++;
    }

    // Okul adında eğer varsa başta ve sondaki boşlukları silme işlemi  
    $userID = trim($_GET["userID"]); 
    $wp_user = find_wp_users_withID($userID);

?>

<div class="container">
    <div class="row">
        <div class="col-12 pt-3 border-bottom border-start border-end">
            <p class="text-center fs-5 fw-bolder">KURS ATAMA > ÇALIŞTIR</p>
        </div>
        <div class="col-12 border p-3">
            <?php 
                echo "<p><strong>Atama Yapılan Kurslar:</strong> ";
                foreach($courses as $course){
                    echo $course." | ";
                }
                echo "</p><hr>";
                echo "<p><strong>Atama Yapılan Kullanıcı:</strong> ID: ".$userID.' > ' . $wp_user['display_name'] . '</p><hr>';  
            ?>
          <?php kursAtamaKullanıcı ( $courses, $userID ); ?>
        </div>
    </div>
</div>
<?php include './footer.php';?>