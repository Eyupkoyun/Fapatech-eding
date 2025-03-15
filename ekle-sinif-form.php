<?php include './header.php';?>
<div class="container">
    <div class="row">
        <div class="col-12 pt-3 border-bottom border-start border-end">
            <p class="text-center fs-5 fw-bolder">SINIF EKLE</p>
        </div>
        <div class="col-12 border p-3">
        <p class="text-center fs-2">Lütfen sınıf bilgilerini giriniz.</p>
        <form class="row" g-12 action="ekle-sinif.php" method="GET">
            <div class="form-group row">
                <label for="schoolClassName" class="col-sm-2 col-form-label">Sınıf Adı</label>
                <div class="col-sm-10  mb-3">
                    <input type="text" class="form-control" id="schoolClassName" name="schoolClassName" placeholder="Sınıf adını giriniz...">
                </div>
                <label for="studentSchool" class="col-sm-2 col-form-label">Okul Seçiniz</label>
                <div class="col-sm-10  mb-3">
                    <select id="inputSchool" name="schoolName" class="form-control">
                        <?php $schools = schools(); ?>
                        <option selected>Sınıfın hangi okulda olduğunu Seçiniz...</option>
                        <?php 
                            // Dizi eleman sayısı kadar dönen bir döngü
                            for ($i = 0; $i < count($schools); $i++) {
                                echo "<option>". $schools[$i]['school_name'] ."</option>";
                            }
                        ?>
                    </select>
                </div>
                <button id="ekleButonu" style="padding: 5px 40px;" type="submit" class="btn btn-primary" disabled>Ekle</button>
                
            </div>
        </form>
        </div>
    </div>
</div>
<script>
    var button = document.getElementById("ekleButonu");

    document.getElementById("inputSchool").addEventListener("change", function() {
        button.removeAttribute('disabled');
    });
</script>
<?php include './footer.php';?>

