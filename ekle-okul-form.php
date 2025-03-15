<?php include './header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-12 pt-3 border-bottom border-start border-end">
            <p class="text-center fs-5 fw-bolder">OKUL EKLE</p>
        </div>
        <div class="col-12 border p-3">
        <p class="text-center fs-2">Lütfen okul adını giriniz.</p>
        <form class="row" g-12 action="ekle-okul.php" method="GET">
            <div class="input-group mb-3">
                <input id="schollNameInput" class="form-control" name="schoolName" placeholder="Lütfen Okul Adını Giriniz">
                    
                <button id="ekleButonu" style="padding: 0 40px;" type="submit" class="btn btn-primary" disabled>Ekle</button>
            </div>
        </form>
        </div>
    </div>
</div>
<script>
    var button = document.getElementById("ekleButonu");

    document.getElementById("schollNameInput").addEventListener("change", function() {
        button.removeAttribute('disabled');
    });
</script>
<?php include './footer.php';?>