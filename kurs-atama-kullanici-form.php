<?php include './header.php';?>

<div class="container">
    <div class="row">
        <div class="col-12 pt-3 border-bottom border-start border-end">
            <p class="text-center fs-5 fw-bolder">KULLANICI'YA ATAMA FORMU</p>
            <p class="text-center">Bu listede öğrenci yada öğretmen olarak eklenmemiş, doğrudan website üzerinden üye olan kullanıcılar görüntülenmektedir.</p>
        </div>
        <div class="col-12 border p-3">
        <form class="row" g-12 action="kurs-atama-kullanici.php" method="GET">
            <div class="form-group row">
                <label id="coursesSelectorLabel" for="inputSchoolClass" class="col-sm-2 col-form-label">Kurs Seçiniz</label>
                <div id ="coursesSelector" class="col-sm-10  mb-3">
                <?php 
                    $courses = courses(); 
                ?>
                <?php if( $courses != 0 ){ ?>
                    <div id="coursesSelector" class="col-sm-10  mb-3">
                    <?php    // output data of each row
                        $counter = 1;
                        foreach( $courses as $course) { ?>
                            
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input 
                                            type="checkbox" 
                                            name="course-<?php echo $counter; ?>" 
                                            value="<?php echo $course['post_title']; ?>" 
                                            class="form-check-input">
                                            <?php echo $course['post_title']; ?>
                                    </label>
                                </div>
                        <?php
                            $counter++;
                        } 
                        ?>
                        </div> 
                <?php } else {
                    echo "Hiç kayıtlı kurs bulunamadı.";
                } ?> 
                
                </div>

                <label for="teacherSchool" class="col-sm-2 col-form-label">Kullanıcı Seçiniz</label>
                <div class="col-sm-10  mb-3">
                    <select id="inputUser" class="form-control" name="userID">
                        <?php $wp_users = wp_users(); ?>
                        <option selected>Kullanıcı Seçiniz...</option>
                        <?php 
                            // Dizi eleman sayısı kadar dönen bir döngü
                            for ($i = 0; $i < count($wp_users); $i++) {
                                $customMetas = findCustomMetasWithWPUserID($wp_users[$i]['ID']);
                               if( $customMetas == 0){
                                    echo "<option value=".$wp_users[$i]['ID'].">ID: " . $wp_users[$i]['ID'] . " > " .$wp_users[$i]['display_name'] ."</option>";
                               }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <button id="ekleButonu" type="submit" class="btn btn-primary" disabled>Gönder</button>
        </form>
        </div>  
    </div>
</div>
<script>
var button = document.getElementById("ekleButonu");

document.getElementById("inputUser").addEventListener("change", function() {
    button.removeAttribute('disabled');
});
</script>
<?php include './footer.php';?>