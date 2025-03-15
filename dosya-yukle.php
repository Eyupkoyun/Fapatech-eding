<?php include './header.php'; $conn = connectDatabase();?>

<div class="container">
        <div class="row pt-3 border-bottom border-start border-end">
            <p class="text-center fs-5 fw-bolder">Dosya Yükle</p>
        </div>
        <div class="row border p-3">
            
        <h1>Excel Dosyasını Yükleyin</h1>
        <form action="excel-process.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="excel_file" accept=".xlsx, .xls" required>
            <button type="submit">Yükle ve Göster</button>
        </form>
        </div> 
    </div>









<?php include './footer.php';?>