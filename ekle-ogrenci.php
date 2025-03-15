<?php include './header.php'; $conn = connectDatabase();?>
<?php  
    // Okul adında eğer varsa başta ve sondaki boşlukları silme işlemi  
    $studentName = trim($_POST["studentName"]); 
    $studentSurname = trim($_POST["studentSurname"]); 
    $studentSchoolName = $_POST["studentSchoolName"]; 
    $studentSchoolClassName = $_POST["studentSchoolClassName"]; 
    // Her kelimenin ilk harfini büyük yapma
    $studentName  = mb_convert_case(ucwords_tr(strtolower_tr( $studentName )), MB_CASE_TITLE, "UTF-8");
    $studentSurname  = mb_convert_case(ucwords_tr(strtolower_tr( $studentSurname )), MB_CASE_TITLE, "UTF-8");
?> 
<?php 
// Form verilerinin boş olup olmadığını kontrol et
if (empty($studentName) || empty($studentSurname) || empty($studentSchoolName) || empty($studentSchoolClassName)) {
    echo '<div class="alert alert-danger">Lütfen tüm alanları doldurun!</div>';
    exit;
}
?>

<div class="container">
    <div class="row">
        <div class="col-12 pt-3 border-bottom border-start border-end">
            <p class="text-center fs-5 fw-bolder">ÖĞRENCİ EKLE > <?php echo $studentName ." ". $studentSurname; ?></p>
        </div>
        <div class="col-12 border p-3">
            <?php 
                echo '<p><strong>Adı:</strong> '.$studentName.'</p>';
                echo '<p><strong>Soyadı:</strong> '.$studentSurname.'</p>';
                echo '<p><strong>Okulu:</strong> '.$studentSchoolName.'</p>';
                echo '<p><strong>Sınıfı:</strong> '.$studentSchoolClassName.'</p>';
            ?>
            <?php 
            try {
                ogrenciEkle($studentName, $studentSurname, $studentSchoolName, $studentSchoolClassName);
                echo '<div class="alert alert-success">Öğrenci başarıyla eklendi!</div>';
            } catch (Exception $e) {
                echo '<div class="alert alert-danger">Öğrenci eklenirken bir hata oluştu: ' . $e->getMessage() . '</div>';
            }
            ?>
        </div>
    </div>
</div>
<?php include './footer.php';?>