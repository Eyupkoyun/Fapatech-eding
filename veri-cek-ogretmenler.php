<?php include './header.php'; ?>

<div class="container">
        <div class="row py-3 border-bottom border-start border-end">
            <div class="fs-5 fw-bolder">ÖĞRETMENLER
                <a class="btn btn-outline-dark mx-4" href="./ekle-ogretmen-form.php" role="button">Öğretmen Ekle</a>
            </div>
        </div>
        <div class="row border p-3">
            <?php $teachers = teachers(); ?>
            <?php if( $teachers != 0 ){ ?>
                <table class="table border-bottom">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Adı Soyadı</th>
                        <th scope="col">Okul</th>
                        <th scope="col">Kullanıcı Adı</th>
                        <th scope="col">Şifre</th>
                        <th scope="col">Kayıt Tarihi</th>
                        <th scope="col">İşlemler</th>
                    </tr>
                </thead>
                <?php    // output data of each row
                    foreach( $teachers as $teacher) {
                        $teacherMetas = findTeachersCustomMetasWithWPUserID($teacher['ID']);
                        // Benzersiz elemanları tutacak dizi
                        $uniqueTeacherMetas = [];
                        // Daha önce görülen user_school_id değerlerini takip etmek için bir kontrol listesi
                        $kontrol = [];
                        foreach ($teacherMetas as $eleman) {
                            $userSchoolId = $eleman["user_school_id"];
                            if (!in_array($userSchoolId, $kontrol)) {
                                $uniqueTeacherMetas[] = $eleman; // Benzersiz elemanı ekle
                                $kontrol[] = $userSchoolId;    // Görülen user_school_id'yi kontrol listesine ekle
                            }
                        }

                ?>
                <tbody>
                    <tr>
                        <td><?php echo $teacher["ID"]; ?></td>
                        <td><?php echo $teacher["display_name"]; ?></td>
                        <td>
                            <?php
                                foreach ($uniqueTeacherMetas as $uniqueTeacherMeta){
                                    $school = findSchoolWithID( $uniqueTeacherMeta['user_school_id'] );
                                    echo "<div><strong>".$school['school_name']."</strong><br> Sınıflar: ";
                                    foreach ($teacherMetas as $teacherMeta) { 
                                        if ( $teacherMeta ['user_school_id'] == $uniqueTeacherMeta['user_school_id']){
                                            $teacherSchool_ID = $uniqueTeacherMeta['user_school_id'];
                                            $teacherClass_ID = $teacherMeta['user_class_id'];
                                            $teacherClass = findSchoolClassWithID( $teacherSchool_ID, $teacherClass_ID );
                                            echo "<span>";
                                            echo $teacherClass['class_name'].", ";
                                            echo "</span>";
                                        }
                                    }
                                    echo "</div>";
                                }
                            ?>
                        </td>
                        <td><?php echo $teacher["user_login"]; ?></td>
                        <td><?php echo $teacher["user_login"]; ?>-2024</td>
                        <td><?php echo $teacher["user_registered"]; ?></td>
                        <td>
                            <a class="btn btn-outline-dark btn-sm" href="<?php echo yonetim_panel_url()."/duzenle-ogretmen-form.php?teacher_ID=".$teacher["ID"]; ?>" role="button">Düzenle</a>
                            <a class="btn btn-outline-dark btn-sm" href="<?php echo yonetim_panel_url()."/ogretmene-okul-ekle-form.php?teacherDisplayName=".$teacher["display_name"]."&teacher_ID=".$teacher["ID"]; ?>" role="button">Okula Ekle</a>
                        </td>
                    </tr>
            
            <?php    } ?>
                </tbody>
        </table>
        <?php 
        } else {
            echo "Hiç kayıtlı öğretmen bulunamadı!";
        } ?> 
        </div> 
    </div>









<?php include './footer.php';?>