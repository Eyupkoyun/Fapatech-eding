<?php
include 'header.php';
include 'navbar.php';
include 'sidebar.php';
include 'includes/db.php';  // Veritabanı bağlantısı
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Öğrenci Ekle</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="ekle-ogrenci.php" method="post">
                                <div class="form-group">
                                    <label for="ad">Öğrenci Adı:</label>
                                    <input type="text" class="form-control" id="ad" name="studentName" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="soyad">Öğrenci Soyadı:</label>
                                    <input type="text" class="form-control" id="soyad" name="studentSurname" required>
                                </div>

                                <div class="form-group">
                                    <label for="okul">Okul:</label>
                                    <select class="form-control" id="okul" name="studentSchoolName" required>
                                        <option value="">Okul Seçin</option>
                                        <?php
                                        // Okulları çek
                                        $sql = "SELECT * FROM eding_custom_schools ORDER BY school_name";
                                        $result = $conn->query($sql);
                                        if ($result && $result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row["school_name"] . "'>" . $row["school_name"] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="sinif">Sınıf:</label>
                                    <select class="form-control" id="sinif" name="studentSchoolClassName" required>
                                        <option value="">Önce Okul Seçin</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="email">E-posta:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>

                                <div class="form-group">
                                    <label for="telefon">Telefon:</label>
                                    <input type="tel" class="form-control" id="telefon" name="telefon" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Öğrenci Ekle</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sınıfları dinamik olarak yüklemek için JavaScript -->
<script>
document.getElementById('okul').addEventListener('change', function() {
    var okulAdi = this.value;
    var sinifSelect = document.getElementById('sinif');
    
    // Okul seçili değilse sınıf seçimini sıfırla
    if (!okulAdi) {
        sinifSelect.innerHTML = '<option value="">Önce Okul Seçin</option>';
        return;
    }

    // AJAX ile sınıfları getir
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_school_classes.php?schoolName=' + encodeURIComponent(okulAdi), true);
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            try {
                var siniflar = JSON.parse(xhr.responseText);
                sinifSelect.innerHTML = '<option value="">Sınıf Seçin</option>';
                
                if (siniflar.length > 0) {
                    siniflar.forEach(function(sinif) {
                        var option = document.createElement('option');
                        option.value = sinif.class_name;
                        option.textContent = sinif.class_name;
                        sinifSelect.appendChild(option);
                    });
                } else {
                    sinifSelect.innerHTML = '<option value="">Bu okula ait sınıf bulunamadı</option>';
                }
            } catch (e) {
                console.error('JSON parse hatası:', e);
                sinifSelect.innerHTML = '<option value="">Sınıf bilgileri alınamadı</option>';
            }
        } else {
            sinifSelect.innerHTML = '<option value="">Sınıf bilgileri alınamadı</option>';
        }
    };
    
    xhr.onerror = function() {
        sinifSelect.innerHTML = '<option value="">Bağlantı hatası oluştu</option>';
    };
    
    xhr.send();
});
</script>

<?php include 'footer.php'; ?>

