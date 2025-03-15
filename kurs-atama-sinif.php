<?php include './header.php'; ?>
<?php
    try {
        $courses = [];
        $counter = 1;
        while($counter < 101){
            if(isset($_GET["course-$counter"])){
                $courses[] = $_GET["course-$counter"];
            }
            $counter++;
        }

        if (empty($courses)) {
            throw new Exception("Lütfen en az bir kurs seçin!");
        }

        $schoolName = trim($_GET["schoolName"]); 
        if (empty($schoolName)) {
            throw new Exception("Okul seçimi yapılmadı!");
        }

        $school = findSchoolWithName($schoolName);
        if (!is_array($school)) {
            throw new Exception("Okul bulunamadı!");
        }

        $studentsCustomMetas = findStudentsCustomMetasWithSchoolID($school['school_ID']);
        if (empty($studentsCustomMetas)) {
            throw new Exception("Bu okulda öğrenci bulunamadı!");
        }
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
                echo "<p><strong>Atama Yapılan Öğrenci ID'leri:</strong> ";
                foreach($studentsCustomMetas as $studentMeta){
                    echo $studentMeta['user_id']." | ";
                }
                echo "</p><hr>";
            ?>
            <?php 
            kursAtamaSinif($courses, $studentsCustomMetas);
            echo '<div class="alert alert-success">Kurs atama işlemi tamamlandı!</div>';
            ?>
        </div>
    </div>
</div>
<?php 
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Hata: ' . $e->getMessage() . '</div>';
    }
    include './footer.php';
?>