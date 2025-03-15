<?php
include 'includes/db.php';  // Veritabanı bağlantısı
include 'header.php';
include 'navbar.php';
include 'sidebar.php';

// Veritabanını seç
$conn->query("USE caferpal_eding_wp_24_v2");

// Öğrenci sayısını çek
$sql_students = "SELECT COUNT(DISTINCT user_id) as student_count 
                FROM eding_custom_users_meta 
                WHERE user_type = 'student' OR user_type = 'Student'";
$result_students = $conn->query($sql_students);
$student_count = $result_students->fetch_assoc()['student_count'];

// Öğretmen sayısını çek
$sql_teachers = "SELECT COUNT(DISTINCT user_id) as teacher_count 
                FROM eding_custom_users_meta 
                WHERE user_type = 'teacher' OR user_type = 'Teacher'";
$result_teachers = $conn->query($sql_teachers);
$teacher_count = $result_teachers->fetch_assoc()['teacher_count'];

// Okul sayısını çek
$sql_schools = "SELECT COUNT(*) as school_count FROM eding_custom_schools";
$result_schools = $conn->query($sql_schools);
$school_count = $result_schools->fetch_assoc()['school_count'];

// Sınıf sayısını çek
$sql_classes = "SELECT COUNT(*) as class_count FROM eding_custom_school_classes";
$result_classes = $conn->query($sql_classes);
$class_count = $result_classes->fetch_assoc()['class_count'];
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Admin Dashboard</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo $student_count; ?></h3>
                            <p>Öğrenciler</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo $teacher_count; ?></h3>
                            <p>Öğretmenler</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo $school_count; ?></h3>
                            <p>Okullar</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-school"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php echo $class_count; ?></h3>
                            <p>Sınıflar</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-door-open"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include 'footer.php'; ?>