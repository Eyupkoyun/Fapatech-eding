<?php
// Veritabanı bağlantı bilgileri
$servername = "localhost";
$username = "root";  // XAMPP varsayılan kullanıcı adı
$password = "";      // XAMPP varsayılan şifre
$dbname = "caferpal_eding_wp_24_v2";   // Mevcut veritabanı adı

// Veritabanı bağlantısını oluştur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

// Türkçe karakter sorununu çözmek için
$conn->set_charset("utf8");
?> 