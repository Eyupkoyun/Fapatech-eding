<?php
include 'includes/db.php';  // Veritabanı bağlantısı

// Veritabanını seç
$conn->query("USE caferpal_eding_wp_24_v2");

// Okul adını al
$schoolName = isset($_GET['schoolName']) ? $_GET['schoolName'] : '';

if ($schoolName) {
    // Önce okul ID'sini bul
    $sql_school = "SELECT school_ID FROM eding_custom_schools WHERE school_name = ?";
    $stmt = $conn->prepare($sql_school);
    $stmt->bind_param("s", $schoolName);
    $stmt->execute();
    $result_school = $stmt->get_result();
    $school = $result_school->fetch_assoc();
    
    if ($school) {
        $school_id = $school['school_ID'];
        
        // Sınıfları çek
        $sql = "SELECT class_ID as class_id, class_name 
                FROM eding_custom_school_classes 
                WHERE class_school_ID = ? 
                ORDER BY class_name";
                
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $school_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $classes = array();
        while ($row = $result->fetch_assoc()) {
            $classes[] = $row;
        }
        
        // JSON olarak döndür
        header('Content-Type: application/json');
        echo json_encode($classes);
    } else {
        // Okul bulunamadı
        header('Content-Type: application/json');
        echo json_encode(array());
    }
} else {
    // Okul adı gönderilmedi
    header('Content-Type: application/json');
    echo json_encode(array());
}
?>