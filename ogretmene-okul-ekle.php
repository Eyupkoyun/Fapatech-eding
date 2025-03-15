<?php include './header.php'; $conn = connectDatabase();?>
<?php  
    // Okul adında eğer varsa başta ve sondaki boşlukları silme işlemi  
    $teacherDisplayName = trim($_GET["teacherDisplayName"]); 
    $teacher_ID = trim($_GET["teacher_ID"]); 
    $teacherSchoolName = trim($_GET["teacherSchoolName"]); 

    echo $teacherDisplayName;
    echo "<br>";
    echo $teacher_ID;
    $counter = 1; $i = 0; // Sayici ve index başlangıç değer atamaları
    while( $counter < 101 ){ // 100 sinifa kadar kontrol eder.
        if( isset( $_GET["teacherSchoolClasses-$counter"] ) ){
            $teacherSchoolClasses[$i] = $_GET["teacherSchoolClasses-$counter"];
            $i++;
        }
        $counter++;
    }
?> 
<?php 


?>

<div class="container">
    <div class="row">
        <div class="col-12 pt-3 border-bottom border-start border-end">
            <p class="text-center fs-5 fw-bolder">ÖĞRETMENE OKUL EKLE > <?php echo $teacherDisplayName; ?></p>
        </div>
        <div class="col-12 border p-3">
            <?php 
                echo '<p><strong>Öğretmen:</strong> '.$teacherDisplayName.'</p>';
                echo '<p><strong>Okul:</strong> '.$teacherSchoolName.'</p>';
                echo '<p><strong>Sınıf:</strong> ';
                foreach ($teacherSchoolClasses as $class) {
                    echo $class .' | ';
                }
                echo "</p>"; 
                
            ?>
            <?php ogretmeneOkulEkle ( $teacher_ID, $teacherDisplayName, $teacherSchoolName, $teacherSchoolClasses ); ?>
        </div>
    </div>
</div>
<?php include './footer.php';?>