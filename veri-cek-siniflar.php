<?php include './header.php';?>

<div class="container">
    <div class="row py-3 border-bottom border-start border-end">
            <div class="fs-5 fw-bolder">SINIFLAR
                <a class="btn btn-outline-dark mx-4" href="./ekle-sinif-form.php" role="button">Sınıf Ekle</a>
            </div>
        </div>
        <div class="row border p-3">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Sınıf ID</th>
                        <th scope="col">Sınıf Adı</th>
                        <th scope="col">Okul ID</th>
                        <th scope="col">Okul Adı</th>
                        <th scope="col">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                <?php $classes = classes(); ?>
                    <?php if( $classes != 0 ){ ?>
                            <?php    // output data of each row
                                foreach( $classes as $class) {
                            ?>
                            <tr>
                                <td><?php echo $class["class_ID"]; ?></td>
                                <td><?php echo $class["class_name"]; ?></td>
                                <td><?php echo $class["class_school_ID"]; ?></td>
                                <?php $school = findSchoolWithID( $class["class_school_ID"] ); ?>
                                <td><?php echo $school["school_name"]; ?></td>
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