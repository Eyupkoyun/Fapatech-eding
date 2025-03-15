<?php include './header.php';?>

<div class="container">
        <div class="row pt-3 border-bottom border-start border-end">
            <p class="text-center fs-5 fw-bolder">KURSLAR</p>
        </div>
        <div class="row border p-3">
            <table class="table border-bottom">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Kurs</th>
                        <th scope="col">Oluşturulma Tarihi</th>
                        <th scope="col">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                <?php $courses = courses(); ?>
                    <?php if( $courses != 0 ){ ?>
                            <?php    // output data of each row
                                foreach( $courses as $course) {
                            ?>
                            <tr>
                                <td><?php echo $course["ID"]; ?></td>
                                <td><a href="https://eding.com.tr/kurslar/<?php echo $course["post_name"];?>" target="_blank"><?php echo $course["post_title"]; ?></a></td>
                                <td><?php echo $course["post_date"]; ?></td>
                                <td><button type="button" class="btn btn-outline-dark btn-sm">Düzenle</button></td>
                            </tr>
                            <?php } ?>
                    </tbody>
                </table>
                    <?php } else {
                        echo "Hiç kayıtlı öğrenci bulunamadı.";
                } ?> 
        </div> 
    </div>









<?php include './footer.php';?>