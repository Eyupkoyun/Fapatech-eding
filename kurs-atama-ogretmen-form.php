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
                    <h1 class="m-0">Öğretmene Kurs Atama</h1>
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
                            <form action="kurs-atama-ogretmen.php" method="GET">
                                <div class="form-group">
                                    <label for="ogretmen">Öğretmen Seçin:</label>
                                    <select class="form-control" name="teacher-1" id="ogretmen" required>
                                        <option value="">Öğretmen Seçin</option>
                                        <?php
                                        // Öğretmenleri çek
                                        $sql = "SELECT DISTINCT u.ID, u.display_name 
                                               FROM eding_custom_users_meta m
                                               JOIN edding_wp_24_users u ON m.user_id = u.ID
                                               WHERE m.user_type = 'teacher' OR m.user_type = 'Teacher'
                                               ORDER BY u.display_name";
                                        
                                        $result = $conn->query($sql);
                                        
                                        if ($result && $result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row["display_name"] . "'>" . $row["display_name"] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="okul">Okul Seçin:</label>
                                    <select class="form-control" name="schoolName" id="okul" required>
                                        <option value="">Okul Seçin</option>
                                        <?php
                                        // Okulları çek
                                        $sql2 = "SELECT * FROM eding_custom_schools ORDER BY school_name";
                                        $result2 = $conn->query($sql2);
                                        if ($result2 && $result2->num_rows > 0) {
                                            while($row = $result2->fetch_assoc()) {
                                                echo "<option value='" . $row["school_name"] . "'>" . $row["school_name"] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="sinif">Sınıf Seçin:</label>
                                    <select class="form-control" name="sinif" id="sinif" required>
                                        <option value="">Önce Okul Seçin</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Kurs Seçin:</label>
                                    <?php
                                    // Kursları çek
                                    $sql_courses = "SELECT post_title FROM edding_wp_24_posts WHERE post_type = 'courses'";
                                    $result_courses = $conn->query($sql_courses);
                                    if ($result_courses && $result_courses->num_rows > 0) {
                                        $counter = 1;
                                        while($row = $result_courses->fetch_assoc()) {
                                            echo '<div class="form-check">';
                                            echo '<input class="form-check-input" type="checkbox" name="course-' . $counter . '" value="' . $row["post_title"] . '" id="course' . $counter . '">';
                                            echo '<label class="form-check-label" for="course' . $counter . '">' . $row["post_title"] . '</label>';
                                            echo '</div>';
                                            $counter++;
                                        }
                                    }
                                    ?>
                                </div>

                                <button type="submit" class="btn btn-primary">Kurs Ata</button>
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