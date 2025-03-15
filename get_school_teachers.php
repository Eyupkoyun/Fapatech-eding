<?php
include './function.php'; 


// Okul adını al
$schoolName = $_GET['schoolName'];
// Okul adından okul bilgilerini al
$school = findSchoolWithName($schoolName);
$teachers = findTeachersWithSchoolID($school['school_ID']);
$schoolTeachers = $schoolTeachers ?? [];
if( $teachers != 0 ){ 
    $i = 0;
    foreach ($teachers as $teacher) {
        // Eğer $teacher['user_id'], $schoolTeachers içinde yoksa
        if (!in_array($teacher['user_id'], $schoolTeachers)) {
            // WP User verilerini alın
            $wpUserData = find_wp_users_withID($teacher['user_id']);
            
            // Kullanıcı ID'sini ayrı bir diziye ekleyin
            $teacher_WP_USER_UserID[$i] = $wpUserData['ID'];
            
            // Eğer bu ID zaten $schoolTeachers dizisinde yoksa, ekleyin
            if (!in_array($wpUserData['ID'], array_column($schoolTeachers, 'ID'))) {
                $schoolTeachers[] = $wpUserData; // Doğrudan wpUserData'yı ekleyin
            }
        }
        $i++;
    }
    echo json_encode($schoolTeachers);
    
} else {
    echo 0;
}


?>