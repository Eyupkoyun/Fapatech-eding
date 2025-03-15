<?php include './function.php'; ?>
<?php
// WordPress şifreleme sınıfını taklit eden kod


// WordPress şifreleme sınıfını taklit eden kod
require_once('./includes/class-phpass.php'); // Phpass kütüphanesi dosyasını ekleyin
// WordPress gibi 8 tur hashing kullan
$wp_hasher = new PasswordHash(8, true);

// Formdan veri al
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username']; // edding_superadmin_24
    $password = $_POST['password']; // FD154y*lj^X9AXBWV#

  
    // Kullanıcıyı veritabanında kontrol et
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.edding_wp_24_users WHERE user_login = '$username';";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        while ($WP_user = $result->fetch_assoc()) {
            $stored_hash = $WP_user['user_pass'];
            $login = $wp_hasher->CheckPassword($password, $stored_hash); 
            if($login == 1){
                $message = "Giriş başarılı!";
                session_start();
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $username;  // Kullanıcı adını session'a kaydediyoruz
                header("Location: index.php"); // Giriş başarılı olduğunda dashboard sayfasına yönlendir
                exit; // Yönlendirme yapıldıktan sonra işlem bitirilmeli
            } else {
                $message = "Şifreniz yanlış lütfen kontrol edin!";
            }
        }
    }
    else {
        $message = "Kullanıcı adı bulunamadı veya yanlış girildi! Lütfen kontrol ediniz.";
    }
    disconnectDatabase($conn);
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .custom-logo{
            margin-top:-200px;
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container form-container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center mb-2">
                <img fetchpriority="high" width="800" height="800" src="https://eding.com.tr/wp-content/uploads/2024/10/eding-logo-2.svg" class="custom-logo" alt="Eding" decoding="async">
            </div>
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h4 class="pt-1">Giriş Yap</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="username" class="form-label">Kullanıcı Adı</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Kullanıcı adınızı girin" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Şifre</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Şifrenizi girin" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
                        </form>    
                            <p class="mt-2 text-center">
                                <?php if ( isset( $message ) ) { echo $message;  } ?>
                            </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional, for interactivity like tooltips, modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>