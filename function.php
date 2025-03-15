<?php
/* -------------------------------------- */
/* WEBSİTE VERİLERİ FONKSİYONLARI */
/* -------------------------------------- */

function site_url(){
    global $server;
    if( $_SERVER['SERVER_NAME'] == "localhost" ){
        return "http://localhost/eding";
    } else {
        return "https://eding.com.tr";
    }
}

function yonetim_panel_url(){
    if( $_SERVER['SERVER_NAME'] == "local" ){
        return "http://localhost/eding/yonetim-paneli/v03";
    } else {
        return "https://eding.com.tr/yonetim-paneli/v03";
    }
}
/* -------------------------------------- */
/* VERİ TABANI BAĞLANTISI FONKSİYONLARI */
/* -------------------------------------- */
function connectDatabase(){ 
    if ( $_SERVER['SERVER_NAME'] == "localhost" ){
        $servername = "localhost";
        $database = "caferpal_eding_wp_24_v2";
        $username = "root";
        $password = "";
    } else {
        $servername = "localhost";
        $database = "caferpal_eding_wp_24_v2";
        $username = "caferpal_web_eding_admin";
        $password = "1z5]GtN7$1]6";
    }

    // Create connection
    $conn = new mysqli($servername, $username, $password);
    mysqli_set_charset($conn, "utf8");

    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function disconnectDatabase($conn){
    $conn->close();
}

/* -------------------------------------- */
/* KURS ATAMA FONKSİYONLARI */
/* -------------------------------------- */

// ÖĞRETMENE KURS ATAMA
function kursAtamaOgretmen ( $courses, $courseTeachers, $schoolName ){
    $conn = connectDatabase();
    $i = 0;
    foreach($courses as $course){
        $courses_WP_POST_DATA[$i] = findCoursesWithPostName($course);
        $courses_WP_POST_IDs[$i] = $courses_WP_POST_DATA[$i][0]['ID'];
        $i++;
    }
    $i = 0;
    foreach($courseTeachers as $teacher){
        $courseTeachers_WP_USER_DATA[$i] = find_wp_users_DisplayName($teacher);
        $courseTeachers_WP_USER_IDs[$i] = $courseTeachers_WP_USER_DATA[$i]['ID'];
        $i++;
    }
    // Mevcut tarih ve saati oluşturma
    $dateTime = date('d F Y @ H:i'); // "17 November 2024 @ 20:21" formatı
    $post_title = 'Course Enrolled &ndash; ' . $dateTime;
    $post_parent = 'course-enrolled-' . strtolower(date('d-F-Y-H-i'));
    foreach($courseTeachers_WP_USER_IDs as $teacher_ID){
            echo "<p>Öğretmen ID: " . $teacher_ID ."</p>"; 
        foreach($courses_WP_POST_IDs as $course_ID){
            echo "<div>Kurs ID: ". $course_ID . "</div> "; 
                $sql="
                    INSERT INTO `caferpal_eding_wp_24_v2`.`edding_wp_24_posts` ( 
                        `post_author`,
                        `post_title`, 
                        `post_status`, 
                        `comment_status`, 
                        `ping_status`, 
                        `post_name`, 
                        `post_parent`, 
                        `guid`, 
                        `menu_order`, 
                        `post_type`, 
                        `comment_count`
                    ) VALUES (
                        '$teacher_ID', 
                        '$post_title', 
                        'completed', 
                        'closed', 
                        'closed', 
                        '$post_parent', 
                        '$course_ID', 
                        'YoneticiAtamasi', 
                        '0', 
                        'tutor_enrolled', 
                        '0'
                    );
                ";
        $result=mysqli_query($conn,$sql);
            
        if  ($result==0) { echo "<span style='color:red;'>Kurs atanamadı, kontrol ediniz!</span>"; }
        else  { echo "<span style='color:green;'>Kurs başarıyla atandı!</span>"; }
        }
    }
    disconnectDatabase($conn);
}

// BİR SINIFTAKİ ÖĞRENCİLERE KURS ATAMA
function kursAtamaSinif ( $courses, $courseStudentsMetas ){
    $conn = connectDatabase();
    
    // Veritabanını seç
    mysqli_select_db($conn, "caferpal_eding_wp_24_v2");
    
    if (empty($courses) || empty($courseStudentsMetas)) {
        throw new Exception("Kurs veya öğrenci verisi bulunamadı!");
    }
    
    $i = 0;
    foreach($courses as $course){
        $courses_WP_POST_DATA[$i] = findCoursesWithPostName($course);
        if (is_array($courses_WP_POST_DATA[$i]) && !empty($courses_WP_POST_DATA[$i])) {
            $courses_WP_POST_IDs[$i] = $courses_WP_POST_DATA[$i][0]['ID'];
        } else {
            throw new Exception("Kurs bulunamadı: " . $course);
        }
        $i++;
    }
    
    if (empty($courses_WP_POST_IDs)) {
        throw new Exception("Geçerli kurs ID'si bulunamadı!");
    }
    
    $i = 0;
    foreach($courseStudentsMetas as $studentMeta){
        if (isset($studentMeta['user_id'])) {
            $courseStudents_IDs[$i] = $studentMeta['user_id'];
            $i++;
        }
    }
    
    if (empty($courseStudents_IDs)) {
        throw new Exception("Geçerli öğrenci ID'si bulunamadı!");
    }

    // Mevcut tarih ve saati oluşturma
    $dateTime = date('d F Y @ H:i'); // "17 November 2024 @ 20:21" formatı
    $post_title = 'Course Enrolled &ndash; ' . $dateTime;
    $post_parent = 'course-enrolled-' . strtolower(date('d-F-Y-H-i'));
    
    foreach($courses_WP_POST_IDs as $course_ID){
        echo "<p>Kurs ID: " . $course_ID ."</p>"; 
        foreach($courseStudents_IDs as $student_ID){
            echo "<div>Öğrenci ID: ". $student_ID . "</div> "; 
            $sql = "INSERT INTO edding_wp_24_posts ( 
                post_author,
                post_title, 
                post_status, 
                comment_status, 
                ping_status, 
                post_name, 
                post_parent, 
                guid, 
                menu_order, 
                post_type, 
                comment_count
            ) VALUES (?, ?, 'completed', 'closed', 'closed', ?, ?, 'YoneticiAtamasi', '0', 'tutor_enrolled', '0')";
            
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Sorgu hazırlanamadı: " . $conn->error);
            }
            
            $stmt->bind_param("isss", $student_ID, $post_title, $post_parent, $course_ID);
            
            if (!$stmt->execute()) {
                echo "<span style='color:red;'>Kurs atanamadı: " . $stmt->error . "</span>";
            } else {
                echo "<span style='color:green;'>Kurs başarıyla atandı!</span>";
            }
        }
    }
    
    disconnectDatabase($conn);
}

function kursAtamaKullanıcı ( $courses, $userID ){
    $conn = connectDatabase();
    $i = 0;
    foreach($courses as $course){
        $courses_WP_POST_DATA[$i] = findCoursesWithPostName($course);
        $courses_WP_POST_IDs[$i] = $courses_WP_POST_DATA[$i][0]['ID'];
        $i++;
    }

    // Mevcut tarih ve saati oluşturma
    $dateTime = date('d F Y @ H:i'); // "17 November 2024 @ 20:21" formatı
    $post_title = 'Course Enrolled &ndash; ' . $dateTime;
    $post_parent = 'course-enrolled-' . strtolower(date('d-F-Y-H-i'));
    
    foreach($courses_WP_POST_IDs as $course_ID){
        echo "<div>Kurs ID: ". $course_ID . "</div> "; 
            $sql="
                INSERT INTO `caferpal_eding_wp_24_v2`.`edding_wp_24_posts` ( 
                    `post_author`,
                    `post_title`, 
                    `post_status`, 
                    `comment_status`, 
                    `ping_status`, 
                    `post_name`, 
                    `post_parent`, 
                    `guid`, 
                    `menu_order`, 
                    `post_type`, 
                    `comment_count`
                ) VALUES (
                    '$userID', 
                    '$post_title', 
                    'completed', 
                    'closed', 
                    'closed', 
                    '$post_parent', 
                    '$course_ID', 
                    'YoneticiAtamasi', 
                    '0', 
                    'tutor_enrolled', 
                    '0'
                );
            ";
    $result=mysqli_query($conn,$sql);
        
    if  ($result==0) { echo "<span style='color:red;'>Kurs atanamadı, kontrol ediniz!</span>"; }
    else  { echo "<span style='color:green;'>Kurs başarıyla atandı!</span>"; }
    }
    
    disconnectDatabase($conn);
}
/* -------------------------------------- */
/* VERİ TABANINDAN BİLGİ ÇEKME FONKSİYONLARI */
/* -------------------------------------- */

// OKUL ID'Sİ İLE VERİ TABANINDAN OKUL BİLGİLERİNİ ÇEKMEK
function findSchoolWithID( $school_ID ){
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.eding_custom_schools WHERE school_ID = '$school_ID';";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $school = $result->fetch_assoc();
        return $school;
    }
    
    else {
        return "Aynı Okul ID'sine sahip birden çok okul bulundu. Hata var kontrol edin!";
    }
    disconnectDatabase($conn);
}

// OKUL ID'Sİ İLE VERİ TABANINDAKİ OKUL META BİLGİLERİNİ ÇEKMEK
function findCustomMetasWithSchoolID( $school_ID ){
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.eding_custom_users_meta WHERE user_school_ID = '$school_ID';";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $schoolCustomMetas = [];
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $schoolCustomMetas[$i] = $row; // Veriyi diziye ekleyebilirsiniz
            $i++;
        }
        return $schoolCustomMetas;
    }
    disconnectDatabase($conn);
}

// OKUL ID'Sİ İLE VERİ TABANINDAN O OKULDAKİ ÖĞRENCİLERİN META VERİLERİNİ ÇEKMEK
function findStudentsCustomMetasWithSchoolID( $school_ID ){
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.eding_custom_users_meta WHERE user_school_ID = '$school_ID' AND user_type = 'student';";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $schoolCustomMetas = [];
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $schoolCustomMetas[$i] = $row; // Veriyi diziye ekleyebilirsiniz
            $i++;
        }
        return $schoolCustomMetas;
    }
    disconnectDatabase($conn);
}
// USER ID İLE WORDPRESS KULLANICI META BİLGİLERİNİ ÇEKMEK
function findTeachersCustomMetasWithWPUserID( $user_id ){
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.eding_custom_users_meta WHERE user_id = '$user_id';";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $customMetas = [];
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $customMetas[$i] = $row; // Veriyi diziye ekleyebilirsiniz
            $i++;
        }
        return $customMetas;
    }
    disconnectDatabase($conn);
}

// USER ID İLE ÖĞRETMENLERİN WORDPRESS KULLANICI META BİLGİLERİNİ ÇEKMEK
function findCustomMetasWithWPUserID( $user_id ){
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.eding_custom_users_meta WHERE user_id = '$user_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $customMetas = [];
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $customMetas[$i] = $row; // Veriyi diziye ekleyebilirsiniz
            $i++;
        }
        return $customMetas;
    } else {
        return 0;
    }

    disconnectDatabase($conn);
}

// USER ID İLE ÖĞRETMENLERİN WORDPRESS KULLANICI META BİLGİLERİNİ ÇEKMEK
function findStudentsCustomMetasWithWPUserID( $user_id ){
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.eding_custom_users_meta WHERE user_id = '$user_id' AND user_type = 'student';";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $studentsCustomMetas = [];
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $studentsCustomMetas[$i] = $row; // Veriyi diziye ekleyebilirsiniz
            $i++;
        }
        return $studentsCustomMetas;
    }
    disconnectDatabase($conn);
}

// OKUL ADI İLE VERİ TABANINDAN OKUL BİLGİLERİNİ ÇEKMEK
function findSchoolWithName( $schoolName ){
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.eding_custom_schools WHERE school_name = '$schoolName';";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $school = $result->fetch_assoc();
        return $school;
    }
    
    else {
        return "Aynı Okul adına sahip birden çok okul bulundu. Yada böyle bir okul bulunamadı. Hata var kontrol edin!";
    }
    disconnectDatabase($conn);
}

// VERİ TABANINDAN KURS BİLGİLERİNİ ÇEKMEK
function courses(){
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.edding_wp_24_posts WHERE post_type = 'courses';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $courses = [];
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $courses[$i] = $row; // Veriyi diziye ekleyebilirsiniz
            $i++;
        }
        return $courses;
    }

    else {
        return "Veri tabanında hiç kurs bulunamadı!";
    }
    disconnectDatabase($conn);
}

// KURS ADI İLE VERİ TABANINDAN WORDPRESS POSTS TABLOSUNDAN KURS BİLGİLERİNİ ÇEKMEK
function findCoursesWithPostName($postName){
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.edding_wp_24_posts WHERE post_type = 'courses' AND post_title = '$postName';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $courses = [];
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $courses[$i] = $row; // Veriyi diziye ekleyebilirsiniz
            $i++;
        }
        return $courses;
    }

    else {
        return "Veri tabanında hiç kurs bulunamadı!";
    }
    disconnectDatabase($conn);
}

// VERİ TABANINDAN OKULLARI ÇEKMEK
function schools(){
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.eding_custom_schools;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $schools = [];
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $schools[$i] = $row; // Veriyi diziye ekleyebilirsiniz
            $i++;
        }
        return $schools;
    }

    else {
        return "Veri tabanında hiç okul bulunamadı!";
    }
    disconnectDatabase($conn);
}

// VERİ TABANINDAN SINIFLARI ÇEKMEK
function classes(){
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.eding_custom_school_classes;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $schools = [];
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $schools[$i] = $row; // Veriyi diziye ekleyebilirsiniz
            $i++;
        }
        return $schools;
    }

    else {
        return "Veri tabanında hiç sınıf bulunamadı!";
    }
    disconnectDatabase($conn);
}

// VERİ TABANINDAN WORDPRESS KULLANICI BİLGİLERİNİ ÇEKMEK
function wp_users(){
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.edding_wp_24_users;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $wp_users = [];
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $wp_users[$i] = $row; // Veriyi diziye ekleyebilirsiniz
            $i++;
        }
        return $wp_users;
    }

    else {
        return "Veri tabanında hiç kullanıcı bulunamadı!";
    }
    disconnectDatabase($conn);
}

// USER ID İLE VERİ TABANINDAN WORDPRESS KULLANICI BİLGİLERİNİ ÇEKMEK
function find_wp_users_withID($userID){
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.edding_wp_24_users WHERE ID = '$userID';";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $wp_user = $result->fetch_assoc();
        return $wp_user;
    }
    
    else {
        return "Aynı ID'ye sahip birden çok okul bulundu. Yada böyle bir öğrenci bulunamadı. Hata var kontrol edin!";
    }
    disconnectDatabase($conn);
}

// DISPLAY NAME İLE VERİ TABANINDAN WORDPRESS KULLANICI BİLGİLERİNİ ÇEKMEK
function find_wp_users_DisplayName($userDisplayName){
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.edding_wp_24_users WHERE display_name = '$userDisplayName';";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $wp_user = $result->fetch_assoc();
        return $wp_user;
    }
    
    else {
        return "Aynı display_name'e sahip birden çok kullanıcı bulundu. Yada böyle bir kullanıcı bulunamadı. Hata var kontrol edin!";
    }
    disconnectDatabase($conn);
}

// VERİ TABANINDAN ÖĞRENCİ BİLGİLERİNİ ÇEKMEK
function students(){
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.eding_custom_users_meta WHERE user_type = 'student';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $students = [];
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $wp_student_user = find_wp_users_withID($row['user_id']);
            $students[$i] = $wp_student_user; // Veriyi diziye ekleyebilirsiniz
            $i++;
        }
        return $students;
    }

    else {
        return 0;
    }
    disconnectDatabase($conn);
}

// VERİ TABANINDAN ÖĞRETMEN BİLGİLERİNİ ÇEKMEK
function teachers(){
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.eding_custom_users_meta WHERE user_type = 'teacher';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $teachers = [];
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $wp_teacher_user = find_wp_users_withID($row['user_id']);
            if (!in_array($wp_teacher_user['ID'], array_column($teachers, 'ID'))) {
            $teachers[$i] = $wp_teacher_user; // Veriyi diziye ekleyebilirsiniz
            $i++;
            }
        }
        return $teachers;
    }

    else {
        return 0;
    }
    disconnectDatabase($conn);
}

// OKUL ID'Sİ İLE VERİ TABANINDAN OKULDAKİ ÖĞRETMENLERİ ÇEKMEK
function findTeachersWithSchoolID( $school_ID ){
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.eding_custom_users_meta WHERE user_type = 'teacher' AND user_school_ID = '$school_ID';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $i = 0;
        while($row = $result->fetch_assoc()) {		
            $schoolClasses[$i] = $row;
            $i++;
        }
        return $schoolClasses;
    } else {
        return 0;
    }
    disconnectDatabase($conn);
}

// OKUL ID'Sİ İLE VERİ TABANINDAN OKULDAKİ SINIFLARI ÇEKMEK
function findSchoolClassesWithSchoolID( $school_ID){
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.eding_custom_school_classes WHERE class_school_ID = '$school_ID';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $i = 0;
        while($row = $result->fetch_assoc()) {		
            $schoolClasses[$i] = $row;
            $i++;
        }
        return $schoolClasses;
    } else {
        return 0;
    }
    disconnectDatabase($conn);
}

// OKUL ID'Sİ VE CLASS ID'Sİ İLE VERİ TABANINDAN BELİRLİ BİR OKULDAKİ SINIFLARI ÇEKMEK
function findSchoolClassWithID( $school_ID, $class_ID ){
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.eding_custom_school_classes WHERE class_school_ID = '$school_ID' AND class_ID = '$class_ID';";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        while($row = $result->fetch_assoc()) {		
            $schoolClass = $row;
        }
        return $schoolClass;
    } else {
        return 0;
    }
    disconnectDatabase($conn);
}

// OKUL ID'Sİ VE SINIF ADI İLE VERİ TABANINDAN BELİRLİ BİR OKULDAKİ SINIFLARI ÇEKMEK
function findSchoolClassWithName( $school_ID, $SchoolClassName ){
    $conn = connectDatabase();
    $sql = "SELECT * FROM caferpal_eding_wp_24_v2.eding_custom_school_classes WHERE class_school_ID = '$school_ID' AND class_name = '$SchoolClassName';";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $class = $result->fetch_assoc();
        return $class;
    }
    
    else {
        return "Aynı sınıf adına sahip birden çok sınıf bulundu. Yada öyle bir sınıf bulunamadı. Hata var kontrol edin!";
    }
    disconnectDatabase($conn);
}

// KULLANICI ADI İLE VERİ TABANINDAN WORDPRESS KULLANICI BİLGİLERİNİ ÇEKMEK
function find_WP_UserWithName( $user_login ){
    $conn = connectDatabase();
    $sql = "SELECT * FROM `caferpal_eding_wp_24_v2`.`edding_wp_24_users` WHERE user_login = '$user_login';";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        return $user;
    }
    
    else {
        return "Aynı sınıf adına sahip birden çok sınıf bulundu. Yada öyle bir sınıf bulunamadı. Hata var kontrol edin!";
    }
    disconnectDatabase($conn);
}

/* -------------------------------------- */
/* VERİ TABANINA BİLGİ EKLE FONKSİYONLARI */
/* -------------------------------------- */

// VERİ TABANINA OKUL EKLEMEK
function okulEkle ( $schoolName ){
    $conn = connectDatabase();
    $sql_1 = "SELECT * FROM `caferpal_eding_wp_24_v2`.`eding_custom_schools` WHERE school_name='$schoolName';";
    $result_1 = mysqli_query($conn, $sql_1);
                
    if ($result_1->num_rows == 0) {  
            $sql_2="INSERT INTO `caferpal_eding_wp_24_v2`.`eding_custom_schools` (`school_ID`, `school_name`)
                VALUES ('', '$schoolName');";
            $result_2=mysqli_query($conn,$sql_2);
        
            if  ($result_2==0) { echo "<span style='color:red;'> | Eklenemedi, kontrol ediniz!</span>"; }
            else  { echo "<span style='color:green;'>Başarıyla eklendi!"; }
    } else { 
            echo "<span style='color:orange;'>Zaten ekli olduğu için eklenmedi!</span>"; 
    }
    disconnectDatabase($conn);
}

// VERİ TABANINA SINIF EKLEMEK
function sinifEkle ( $schoolName, $schoolClassName ){
    $school = findSchoolWithName( $schoolName );
    $school_ID = $school['school_ID'];

    $conn = connectDatabase();
    $sql_1 = "SELECT * FROM `caferpal_eding_wp_24_v2`.`eding_custom_school_classes` WHERE class_name = '$schoolClassName' AND class_school_ID='$school_ID';";
    $result_1 = mysqli_query($conn, $sql_1);
                
    if ($result_1->num_rows == 0) {  
            $sql_2="INSERT INTO `caferpal_eding_wp_24_v2`.`eding_custom_school_classes` (
                `class_ID`, 
                `class_name`, 
                `class_school_ID`
                )
                VALUES (
                '',
                '$schoolClassName',
                '$school_ID'
                );";

            $result_2=mysqli_query($conn,$sql_2);
        
            if  ($result_2==0) { echo "<span style='color:red;'> | Eklenemedi, kontrol ediniz!</span>"; }
            else  { echo "<span style='color:green;'>Başarıyla eklendi!"; }
    } else { 
            echo "<span style='color:orange;'>Zaten ekli olduğu için eklenmedi!</span>"; 
    }
    disconnectDatabase($conn);
}

// VERİ TABANINA CUSTOM USER META EKLEMEK
function customUserMetaEkle ( $user_id, $user_school_id, $user_class_id, $user_type ){
    $conn = connectDatabase();
    $sql_1 = "SELECT * FROM `caferpal_eding_wp_24_v2`.`eding_custom_users_meta` 
        WHERE 
            user_id = '$user_id'
        AND
            user_school_id ='$user_school_id'
        AND
            user_class_id = '$user_class_id'
        AND
            user_type = '$user_type'
            ;
    ";
    $result_1 = mysqli_query($conn, $sql_1);
                
    if ($result_1->num_rows == 0) {  
            $sql_2="
                        INSERT INTO `caferpal_eding_wp_24_v2`.`eding_custom_users_meta` (
                        `user_id`,
                        `user_school_id`,
                        `user_class_id`,
                        `user_type`
                        ) VALUES (
                        '$user_id',
                        '$user_school_id',
                        '$user_class_id',
                        '$user_type'
                        );
                     ";;
            $result=mysqli_query($conn,$sql_2);
        
            if  ($result==0) { echo "<p style='color:red;'> | Eklenemedi, kontrol ediniz!</p>"; }
            else  { echo "<p style='color:green;'>Kullancı meta verisi başarıyla eklendi!</p>"; }
    } else { 
            echo "<p style='color:orange;'>Kullancı meta verisi zaten ekli olduğu için eklenmedi!</p>"; 
    }
    disconnectDatabase($conn);
}

// VERİ TABANINA  ÖĞRENCİ EKLEMEK
function ogrenciEkle ( $studentName, $studentSurname, $studentSchoolName, $studentSchoolClassName ){
    $conn = connectDatabase();
    
    // Veritabanını seç
    mysqli_select_db($conn, "caferpal_eding_wp_24_v2");
    
    // Okul ID'sini bul
    $sql = "SELECT school_ID FROM eding_custom_schools WHERE school_name = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Okul sorgusu hazırlanamadı: " . $conn->error);
    }
    $stmt->bind_param("s", $studentSchoolName);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception("Okul bulunamadı!");
    }
    
    $school = $result->fetch_assoc();
    $school_ID = $school['school_ID'];
    
    // Sınıf ID'sini bul
    $sql = "SELECT class_ID FROM eding_custom_school_classes WHERE class_school_ID = ? AND class_name = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Sınıf sorgusu hazırlanamadı: " . $conn->error);
    }
    $stmt->bind_param("is", $school_ID, $studentSchoolClassName);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception("Sınıf bulunamadı!");
    }
    
    $class = $result->fetch_assoc();
    $class_ID = $class['class_ID'];
    
    // Öğrenci kullanıcı adını oluştur
    $user_login = strtolower(convertToSlug($studentName . $studentSurname));
    
    // WordPress kullanıcısı oluştur
    $sql = "INSERT INTO edding_wp_24_users (user_login, user_pass, user_nicename, user_email, user_registered, display_name) 
            VALUES (?, MD5(RAND()), ?, ?, NOW(), ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Kullanıcı sorgusu hazırlanamadı: " . $conn->error);
    }
    $email = $user_login . "@example.com"; // Geçici e-posta
    $display_name = $studentName . " " . $studentSurname;
    $stmt->bind_param("ssss", $user_login, $user_login, $email, $display_name);
    
    if (!$stmt->execute()) {
        throw new Exception("Kullanıcı oluşturulamadı: " . $stmt->error);
    }
    
    $user_id = $conn->insert_id;
    
    // Öğrenci meta verilerini ekle
    $user_type = "student";
    $sql = "INSERT INTO eding_custom_users_meta (user_id, user_school_ID, user_class_ID, user_type) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Meta veri sorgusu hazırlanamadı: " . $conn->error);
    }
    $stmt->bind_param("iiis", $user_id, $school_ID, $class_ID, $user_type);
    
    if (!$stmt->execute()) {
        throw new Exception("Öğrenci meta verileri eklenemedi: " . $stmt->error);
    }
    
    disconnectDatabase($conn);
    return true;
}

// VERİ TABANINA ÖĞRETMEN EKLEMEK
function ogretmenEkle ( $teacherName, $teacherSurname, $teacherSchoolName, $teacherSchoolClassesNames ){
    $conn = connectDatabase();
    // Eğer varsa öğrenci adında başta ve sondaki boşlukları silme işlemi  
    $teacherName = trim($teacherName); 
    // Öğrenci adında her kelimenin ilk harfini büyük yapma
    $teacherName = mb_convert_case(ucwords_tr(strtolower_tr($teacherName)), MB_CASE_TITLE, "UTF-8");
    // Eğer varsa öğrenci soyadında başta ve sondaki boşlukları silme işlemi  
    $teacherSurname = trim($teacherSurname); 
    // Öğrenci soyadında her kelimenin ilk harfini büyük yapma
    $teacherSurname = mb_convert_case(ucwords_tr(strtolower_tr($teacherSurname)), MB_CASE_TITLE, "UTF-8");
    // Öğrencinin görünen ismini "Adı Soyadı" haline getirme
    $teacherDisplayName = $teacherName . " " . $teacherSurname;
    // Öğrenci icin "adi-soyadi" şeklinde kullanıcı adı oluşturma işlemleri
    $slugTeacherName = convertToSlug($teacherName); 
    $slugTeacherSurname = convertToSlug($teacherSurname);
    $teacherLogin = $slugTeacherName . "-" . $slugTeacherSurname;

    // Öğrenci parolası işlemleri
    $password = $teacherLogin ."-". date('Y');
    // WordPress şifreleme sınıfını taklit eden kod
    require_once('./includes/class-phpass.php'); // Phpass kütüphanesi dosyasını ekleyin
    // WordPress gibi 8 tur hashing kullan
    $wp_hasher = new PasswordHash(8, true);
    // Şifreyi hashle
    $hashed_password = $wp_hasher->HashPassword($password);
    // Öğrenci için eding.com.tr uzantılı mail hesabı verisi
    $teacherEmail = $teacherLogin . "@eding.com.tr";
    // Veri tabanı kayıt tarihi
    $datetimeFormat = 'Y-m-d H:i:s';
    $date = new \DateTime('now', new \DateTimeZone('Europe/Istanbul'));
    $registerDate = $date->format($datetimeFormat); 
    // Veri tabanında kayit olup olmadını sorgulama
    $sql_1 = "SELECT * FROM `caferpal_eding_wp_24_v2`.`edding_wp_24_users` WHERE user_login = '$teacherLogin'";
    $result_1 = mysqli_query($conn, $sql_1);
    if ($result_1->num_rows == 0) {  
            $sql_2= "
                        INSERT INTO `caferpal_eding_wp_24_v2`.`edding_wp_24_users` (
                        `user_login`,
                        `user_pass`,
                        `user_nicename`,
                        `user_email`,
                        `user_registered`,
                        `user_status`,
                        `display_name`
                        ) VALUES (
                        '$teacherLogin',
                        '$hashed_password',
                        '$teacherLogin',
                        '$teacherEmail',
                        '$registerDate',
                        '0',
                        '$teacherDisplayName'
                        );
                     ";
            $result=mysqli_query($conn,$sql_2);
        
            if  ( $result == 0 ) {
                echo "<p style='color:red;'> | Zaten ekli olduğu için yada herhangi bir sorundan dolayı öğrenci eklenemedi, kontrol ediniz!</p>"; 
            }
            else  { 
                echo "<p style='color:green;'>Öğretmen başarıyla eklendi!</p>"; 

                $teacherSchool = findSchoolWithName( $teacherSchoolName);
                $teacherSchool_ID = $teacherSchool['school_ID'];
                $i = 0;
                foreach ($teacherSchoolClassesNames as $class) {
                    $teacherSchoolClasses[$i] = findSchoolClassWithName( $teacherSchool_ID, $teacherSchoolClassesNames[$i]);
                    $teacherSchoolClasses_ID[$i] = $teacherSchoolClasses[$i]['class_ID'];
                    $i++;
                } 
                echo "<p>";
                echo "School ID: " . $teacherSchool_ID;
                echo "</p>";
                echo "<p>";
                echo "Class ID's: ";
                foreach ($teacherSchoolClasses_ID as $class) {
                    echo $class .' | ';
                }
                echo "</p>";

                $teacher_WP_user = find_WP_UserWithName($teacherLogin);
                $teacher_WP_user_ID = $teacher_WP_user['ID'];
                echo "<p>";
                echo "Teacher WP User ID: " . $teacher_WP_user_ID;
                echo "</p>";
                $user_type = "teacher";
                $i = 0;
                foreach ($teacherSchoolClasses_ID as $class) {
                    customUserMetaEkle ( $teacher_WP_user_ID, $teacherSchool_ID, $teacherSchoolClasses_ID[$i], $user_type );
                    $i++;
                }
                
            }
    } else { 
            echo "<span style='color:orange;'>Öğretmen zaten ekli olduğu için eklenmedi!</span>"; 
    }
    disconnectDatabase($conn);
}
    
// BİR ÖĞRETMENE İKİNCİ OKULU EKLEMEK
function ogretmeneOkulEkle( $teacher_ID, $teacherDisplayName, $teacherSchoolName, $teacherSchoolClassesNames ){
    $conn = connectDatabase();
    $teacherSchool = findSchoolWithName( $teacherSchoolName);
    $teacherSchool_ID = $teacherSchool['school_ID'];
    $i = 0;
    foreach ($teacherSchoolClassesNames as $class) {
        $teacherSchoolClasses[$i] = findSchoolClassWithName( $teacherSchool_ID, $teacherSchoolClassesNames[$i]);
        $teacherSchoolClasses_ID[$i] = $teacherSchoolClasses[$i]['class_ID'];
        $i++;
    } 
    echo "<p>";
    echo "School ID: " . $teacherSchool_ID;
    echo "</p>";
    echo "<p>";
    echo "Class ID's: ";
    foreach ($teacherSchoolClasses_ID as $class) {
        echo $class .' | ';
    }
    echo "</p>";

    $teacher_WP_user = find_wp_users_withID($teacher_ID);
    $teacher_WP_user_ID = $teacher_WP_user['ID'];
    echo "<p>";
    echo "Teacher WP User ID: " . $teacher_WP_user_ID;
    echo "</p>";
    $user_type = "teacher";
    $i = 0;
    foreach ($teacherSchoolClasses_ID as $class) {
        customUserMetaEkle ( $teacher_WP_user_ID, $teacherSchool_ID, $teacherSchoolClasses_ID[$i], $user_type );
        $i++;
    }
    disconnectDatabase($conn);
}


// Türkçe karakter desteği ile manuel dönüşüm
function turkish_title_case($string) {
    trim($string);
    // Türkçe küçükten büyüğe dönüşüm haritalaması
    $lowerToUpper = [
        'ı' => 'I', 'i' => 'İ', 'ğ' => 'Ğ', 
        'ü' => 'Ü', 'ş' => 'Ş', 'ö' => 'Ö', 'ç' => 'Ç'
    ];

    // Tüm harfleri küçük yap ve ardından ilk harfleri büyüt
    $string = mb_strtolower($string, "UTF-8");
    $string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8"); // Kelime başındaki harfi büyütme

    // Harf dönüşümünü uygula
    //$string = strtr($string, $lowerToUpper);
    
    return $string;
}

function strtoupper_tr($string)    {
    $string = str_replace("ç","Ç",$string);
    $string = str_replace("ğ","Ğ",$string);
    $string = str_replace("ı","I",$string);
    $string = str_replace("i","İ",$string);
    $string = str_replace("ö","Ö",$string);
    $string = str_replace("ü","Ü",$string);
    $string = str_replace("ş","Ş",$string);

    $string = strtoupper($string);
    $string = trim($string);

    return $string;
}

function strtolower_tr($string){
    $string = str_replace("Ç","ç",$string);
    $string = str_replace("Ğ","ğ",$string);
    $string = str_replace("I","ı",$string);
    $string = str_replace("İ","i",$string);
    $string = str_replace("Ö","ö",$string);
    $string = str_replace("Ü","ü",$string);
    $string = str_replace("Ş","ş",$string);

    $string = strtolower($string);
    $string = trim($string);

    return $string;
}

function ucwords_tr($string){
    $string = explode(" ",trim($string));
    if(isset($string[1])){
        $string2 = $string[1];
    }
    $string_tr = "";

    for($x=0; $x < count($string); $x++)
        {
        $string_bas = substr($string[$x],0,1);
        $string_son = substr($string[$x],1);
        $string_bas = strtoupper_tr($string_bas);

        $string_tr .= $string_bas.$string_son." ";
        }

    $string_tr = trim($string_tr);

    return $string_tr;
}

function convertToSlug($string) {
    // Türkçe karakterleri İngilizce karşılıklarına çevir
    $turkish = ['ç', 'Ç', 'ğ', 'Ğ', 'ı', 'İ', 'ö', 'Ö', 'ş', 'Ş', 'ü', 'Ü'];
    $english = ['c', 'c', 'g', 'g', 'i', 'i', 'o', 'o', 's', 's', 'u', 'u'];
    $string = str_replace($turkish, $english, $string);

    // Küçük harfe çevir
    $string = strtolower($string);

    // Boşlukları ve özel karakterleri tire ile değiştir
    $string = preg_replace('/[^a-z0-9]+/i', '-', $string);

    // Başta ve sonda oluşan tireleri temizle
    $string = trim($string, '-');

    return $string;
}


?>

