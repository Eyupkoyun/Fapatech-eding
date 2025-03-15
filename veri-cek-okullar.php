<?php include './header.php';?>

<div class="container">
    <div class="row py-3 border-bottom border-start border-end">
            <div class="fs-5 fw-bolder">OKULLAR
            <a class="btn btn-outline-dark mx-4" href="./ekle-okul-form.php" role="button">Okul Ekle</a>
            </div>
        </div>
        <div class="row border p-3">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Okul ID</th>
                        <th scope="col">Okul Adı</th>
                        <th scope="col">Okula Eklenen Sınıflar</th>
                        <th scope="col">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                <?php $schools = schools(); ?>
                    <?php if( $schools != 0 ){ ?>
                            <?php    // output data of each row
                                foreach( $schools as $school) {
                            ?>
                            <tr>
                                <td><?php echo $school["school_ID"]; ?></td>
                                <td><?php echo $school["school_name"]; ?></td>
                                <td>
                                <?php 
                                    $schoolClasses = findSchoolClassesWithSchoolID( $school["school_ID"]);
                                    if (is_array($schoolClasses)) {
                                        foreach ($schoolClasses as $class) {
                                            echo $class['class_name']. ", ";
                                        }
                                    } else {
                                        echo "Okula eklenmiş herhangi bir sınıf bulunamadı.";
                                    }
                                ?>
                                </td>
                                <td><button type="button" class="btn btn-outline-dark btn-sm">Düzenle</button></td>
                            </tr>
                            <?php } ?>
                    </tbody>
                </table>
                    <?php } else {
                        echo "Hiç kayıtlı sınıf bulunamadı.";
                } ?> 
        </div> 
    </div>









<?php include './footer.php';?>