<?php include './header.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-12 pt-3 border-bottom border-start border-end">
            <p class="text-center fs-5 fw-bolder">ÖĞRETMEN EKLE</p>
        </div>
        <div class="col-12 border p-3">
        <p class="text-center fs-2">Lütfen öğretmen bilgilerini giriniz.</p>
        <form class="row" g-12 action="ekle-ogretmen.php" method="GET">
            <div class="form-group row">
                <label for="teacherName" class="col-sm-2 col-form-label">Adı</label>
                <div class="col-sm-10  mb-3">
                    <input type="text" class="form-control" id="teacherName" name="teacherName" placeholder="Öğretmen adını giriniz...">
                </div>
                <label for="teacherSurname" class="col-sm-2 col-form-label">Soyadı</label>
                <div class="col-sm-10  mb-3">
                    <input type="text" class="form-control" id="teacherSurname" name="teacherSurname" placeholder="Öğretmen soyadını giriniz...">
                </div>
                <label for="teacherSchool" class="col-sm-2 col-form-label">Okulunu Seçiniz</label>
                <div class="col-sm-10  mb-3">
                    <select id="inputSchool" class="form-control" name="teacherSchoolName">
                        <?php $schools = schools(); ?>
                        <option selected>Öğretmenin Okulunu Seçiniz...</option>
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
            <button id="ekleButonu" type="submit" class="btn btn-primary" disabled>Ekle</button>
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

