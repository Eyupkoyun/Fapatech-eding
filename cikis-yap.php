<?php
session_start();
session_unset();  // Session verilerini temizle
session_destroy();  // Session'ı sonlandır
header("Location: giris-yap.php");  // Çıkış yaptıktan sonra giriş sayfasına yönlendir
exit;
?>