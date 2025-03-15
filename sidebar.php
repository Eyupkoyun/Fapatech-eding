<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="./" class="brand-link">
        <img src="https://eding.com.tr/wp-content/uploads/2024/10/eding-logo-2.svg" alt="Eding Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Eding Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">
                    <i class="fas fa-user-circle mr-2"></i>
                    <?php echo htmlspecialchars($username); ?>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Kurs Atama -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Kurs Atama</p>
                        <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="kurs-atama-ogretmen-form.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Öğretmene Kurs Atama</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="kurs-atama-sinif-form.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sınıfa Kurs Atama</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="kurs-atama-kullanici-form.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kullanıcı'ya Kurs Atama</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Veriler -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>Veriler</p>
                        <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="veri-cek-kurslar.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kurslar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="veri-cek-kullanicilar.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tüm Kullanıcılar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="veri-cek-okullar.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Okullar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="veri-cek-siniflar.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sınıflar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="veri-cek-ogrenciler.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Öğrenciler</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="veri-cek-ogretmenler.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Öğretmenler</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Ekle -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-plus"></i>
                        <p>Ekle</p>
                        <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="ekle-ogrenci-form.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Öğrenci Ekle</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="ekle-ogretmen-form.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Öğretmen Ekle</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="ekle-okul-form.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Okul Ekle</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="ekle-sinif-form.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sınıf Ekle</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>