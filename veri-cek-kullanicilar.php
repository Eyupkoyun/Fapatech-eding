<?php include './header.php';?>

<div class="container">
        <div class="row pt-3 border-bottom border-start border-end">
            <p class="text-center fs-5 fw-bolder">KULLANICILAR</p>
        </div>
        <div class="row border p-3">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Adı Soyadı</th>
                        <th scope="col">Email</th>
                        <th scope="col">Kullanıcı Adı</th>
                        <th scope="col">Kayıt Tarihi</th>
                        <th scope="col">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                <?php $wp_users = wp_users(); ?>
                    <?php if( $wp_users != 0 ){ ?>
                            <?php    // output data of each row
                                foreach( $wp_users as $user) {
                            ?>
                            <tr>
                                <td><?php echo $user["ID"]; ?></td>
                                <td><?php echo $user["display_name"]; ?></td>
                                <td><?php echo $user["user_email"]; ?></td>
                                <td><?php echo $user["user_login"]; ?></td>
                                <td><?php echo $user["user_registered"]; ?></td>
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