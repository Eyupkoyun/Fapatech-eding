<?php include './header.php'; ?>

<div class="container">
        <div class="row py-3 border-bottom border-start border-end">
            <div class="fs-5 fw-bolder">ÖĞRENCİLER
            <a class="btn btn-outline-dark mx-4" href="./ekle-ogrenci-form.php" role="button">Öğrenci Ekle</a>
            </div>
        </div>
        <div class="row border p-3">
            <?php $students = students(); ?>
            <?php if( $students != 0 ){ ?>
                <table class="table border-bottom">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Adı Soyadı</th>
                        <th scope="col">Okul</th>
                        <th scope="col">Email</th>
                        <th scope="col">Kullanıcı Adı</th>
                        <th scope="col">Kayıt Tarihi</th>
                        <th scope="col">İşlemler</th>
                    </tr>
                </thead>
                <?php    // output data of each row
                    foreach( $students as $student) {
                        $studentMetas = findStudentsCustomMetasWithWPUserID($student['ID']);
                        // Benzersiz elemanları tutacak dizi
                        $uniqueStudentMetas = [];
                        // Daha önce görülen user_school_id değerlerini takip etmek için bir kontrol listesi
                        $kontrol = [];
                        foreach ($studentMetas as $eleman) {
                            $userSchoolId = $eleman["user_school_id"];
                            if (!in_array($userSchoolId, $kontrol)) {
                                $uniqueStudentMetas[] = $eleman; // Benzersiz elemanı ekle
                                $kontrol[] = $userSchoolId;    // Görülen user_school_id'yi kontrol listesine ekle
                            }
                        }
                ?>
                <tbody>
                    <tr>
                        <td><?php echo $student["ID"]; ?></td>
                        <td><?php echo $student["display_name"]; ?></td>
                        <td>
                            <?php
                                foreach ($uniqueStudentMetas as $uniqueStudentMeta){
                                    $school = findSchoolWithID( $uniqueStudentMeta['user_school_id'] );
                                    echo "<div> -> ".$school['school_name'];
                                    echo "<ul>";
                                    foreach ($studentMetas as $studentMeta) { 
                                        if ( $studentMeta ['user_school_id'] == $uniqueStudentMeta['user_school_id']){
                                            $studentSchool_ID = $uniqueStudentMeta['user_school_id'];
                                            $studentClass_ID = $studentMeta['user_class_id'];
                                            $studentClass = findSchoolClassWithID( $studentSchool_ID, $studentClass_ID );
                                            echo "<li style='float:left; margin-right:30px;'>";
                                            echo $studentClass['class_name'];
                                            echo "</li>";
                                        }
                                    }
                                    echo "</ul>";
                                    echo "</div>";
                                }
                            ?>
                        </td>
                        <td><?php echo $student["user_email"]; ?></td>
                        <td><?php echo $student["user_login"]; ?></td>
                        <td><?php echo $student["user_registered"]; ?></td>
                        <td>
                            <a class="btn btn-outline-dark btn-sm" href="<?php echo yonetim_panel_url()."/duzenle-ogrenci-form.php?student_ID=".$student["ID"]; ?>" role="button">Düzenle</a>
                        </td>
                    </tr>
            
            <?php    } ?>
                </tbody>
        </table>
        <?php 
        } else {
            echo "Hiç kayıtlı öğrenci bulunamadı!";
        } ?> 
        </div> 
    </div>









<?php include './footer.php';?>