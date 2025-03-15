<?php include './header.php'; $conn = connectDatabase();?>
<?php  
    // Okul adında eğer varsa başta ve sondaki boşlukları silme işlemi  
    $teacherName = trim($_GET["teacherName"]); 
    $teacherSurname = trim($_GET["teacherSurname"]); 
    $teacherSchoolName = trim($_GET["teacherSchoolName"]); 

    $counter = 1; $i = 0; // Sayici ve index başlangıç değer atamaları
    while( $counter < 101 ){ // 100 sinifa kadar kontrol eder.
        if( isset( $_GET["teacherSchoolClasses-$counter"] ) ){
            $teacherSchoolClasses[$i] = $_GET["teacherSchoolClasses-$counter"];
            $i++;
        }
        $counter++;
    }

    // Her kelimenin ilk harfini büyük yapma
    $teacherName  = mb_convert_case(ucwords_tr(strtolower_tr( $teacherName )), MB_CASE_TITLE, "UTF-8");
    $teacherSurname  = mb_convert_case(ucwords_tr(strtolower_tr( $teacherSurname )), MB_CASE_TITLE, "UTF-8");
?> 
<?php 


?>

<div class="container">
    <div class="row">
        <div class="col-12 pt-3 border-bottom border-start border-end">
            <p class="text-center fs-5 fw-bolder">ÖĞRETMEN EKLE > <?php echo $teacherName ." ". $teacherSurname; ?></p>
        </div>
        <div class="col-12 border p-3">
            <?php 
                echo '<p><strong>Adı:</strong> '.$teacherName.'</p>';
                echo '<p><strong>Soyadı:</strong> '.$teacherSurname.'</p>';
                echo '<p><strong>Okulu:</strong> '.$teacherSchoolName.'</p>';
                echo '<p><strong>Sınıfları:</strong> ';
                foreach ($teacherSchoolClasses as $class) {
                    echo $class .' | ';
                }
                echo "</p>";
                
            ?>
            <?php ogretmenEkle ( $teacherName, $teacherSurname, $teacherSchoolName, $teacherSchoolClasses ); ?>
        </div>
    </div>
</div>
<?php include './footer.php';?>