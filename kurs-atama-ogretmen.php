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

    $counter = 1; $i = 0; // Sayici ve index başlangıç değer atamaları
    while( $counter < 101 ){ // 100 sinifa kadar kontrol eder.
        if( isset( $_GET["teacher-$counter"] ) ){
            $courseTeachers[$i] = $_GET["teacher-$counter"];
            $i++;
        }
        $counter++;
    }

    // Okul adında eğer varsa başta ve sondaki boşlukları silme işlemi  
    $schoolName = trim($_GET["schoolName"]); 
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
                echo "<p><strong>Okul:</strong> ".$schoolName.'</p><hr>';  
                echo "<p><strong>Atama Yapılan Öğretmen:</strong> ";
                foreach($courseTeachers as $teacher){
                    echo $teacher." | ";
                }
                echo "</p><hr>";
            ?>
          <?php kursAtamaOgretmen ( $courses, $courseTeachers, $schoolName ); ?>
        </div>
    </div>
</div>
<?php include './footer.php';?>