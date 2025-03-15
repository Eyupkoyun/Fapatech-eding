<?php include './header.php';?>
<?php 

?>

<div class="container">
    <div class="row">
        <div class="col-12 pt-3 border-bottom border-start border-end">
            <p class="text-center fs-5 fw-bolder">SINIFLARA DERS ATAMA FORMU</p>
        </div>
        <div class="col-12 border p-3">
        <form class="row" g-12 action="kurs-atama-sinif.php" method="GET">
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

                <label for="teacherSchool" class="col-sm-2 col-form-label">Okul Seçiniz</label>
                <div class="col-sm-10  mb-3">
                    <select id="inputSchool" class="form-control" name="schoolName">
                        <?php $schools = schools( $conn ); ?>
                        <option selected>Okul Seçiniz...</option>
                        <?php 
                            // Dizi eleman sayısı kadar dönen bir döngü
                            for ($i = 0; $i < count($schools); $i++) {
                                echo "<option>". $schools[$i]['school_name'] ."</option>";
                            }
                        ?>
                    </select>
                </div>
                <label id="schoolClassesSelectorLabel" for="inputSchoolClass" class="col-sm-2 col-form-label" style="display:none;">Sınıfını Seçiniz</label>
                <div id ="schoolClassesSelector" class="col-sm-10  mb-3" style="display:none;">
                
                </div>
            </div>
            <button id="ekleButonu" type="submit" class="btn btn-primary" disabled>Gönder</button>
        </form>
        </div>  
    </div>
</div>
<script>
document.getElementById("inputSchool").addEventListener("change", function() {
    if(document.getElementById("inputSchool").value != "Öğretmenin Okulunu Seçiniz...") {
        document.getElementById("inputSchool").classList.add("readonly");
    }

    var schoolName = this.value;
    if (schoolName) {
        
        // Okul seçildi, sınıflar yüklenmeye başlasın
        var xhr = new XMLHttpRequest(); 
        xhr.open("GET", "get_school_classes.php?schoolName=" + schoolName, true);
        xhr.onload = function() {
            if (xhr.status === 200) {       
                document.getElementById("schoolClassesSelector").style.display = "block"; // Sınıf div'ini göster
                document.getElementById("schoolClassesSelectorLabel").style.display = "block"; // Sınıf div'ini göster
                var classes = JSON.parse(xhr.responseText);
                var classesSelect = document.getElementById("schoolClassesSelector");
                var counter = 1;
                classes.forEach(function(classObj) {
                    
                    // Check Div oluştur
                    var checkDiv = document.createElement("div");
                    checkDiv.classList.add("form-check");
                    checkDiv.classList.add("form-check-inline");
                    

                    // Label oluştur
                    var label = document.createElement("label");
                    label.textContent = classObj.class_name;
                    label.classList.add("form-check-label");
                    

                    // Checkbox oluştur
                    var checkbox = document.createElement("input");
                    checkbox.type = "checkbox";
                    checkbox.name = "teacherSchoolClasses-" + counter; // Dinamik name değeri
                    counter++;
                    checkbox.value = classObj.class_name;
                    checkbox.classList.add("form-check-input");

                    // Form container'a label'ı ekle
                    classesSelect.appendChild(checkDiv);

                    // Form container'a label'ı ekle
                    checkDiv.appendChild(label);

                    // Label içine checkbox'ı ekle
                    label.prepend(checkbox);

                });
            
            }
        };
        xhr.send();
    } else {
        // Okul seçilmedi, sınıf div'ini gizle
        document.getElementById("inputSchool").style.display = "none";
    }
});

var button = document.getElementById("ekleButonu");

document.getElementById("schoolClassesSelector").addEventListener("change", function() {
    button.removeAttribute('disabled');
});
</script>
<?php include './footer.php';?>