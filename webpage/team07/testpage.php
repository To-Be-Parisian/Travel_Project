<?php
include "db.php"; // 데이터베이스 연결 설정 파일


// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
// 데이터베이스 연결 설정 파일
// 폼이 제출되었을 때 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (isset($_SESSION['userid'])) {
        // Get the logged-in user's ID
        $ID = $_SESSION['userid'];
        $travel_purpose = $_POST["travel_purpose"];
        $visit_duration = $_POST["visit_duration"];

        // 데이터베이스에 데이터 삽입
        $sql = "INSERT INTO user_input (UserID, purpose, period) VALUES ('".$_SESSION['userid']."', '".$travel_purpose."', '".$visit_duration."')";


        if ($db->query($sql) === TRUE) {
            echo "<script> location.href='home.php';</script>";
        } else {
            echo "error: " . $sql . "<br>" . $db->error;
        }
    } else {
        echo "User not logged in"; // 디버깅용 메시지
    }
    
}

// 데이터베이스 연결 종료
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Travel Form</title>
    <link rel="stylesheet" type="text/css" href="./static/css/testpage.css" />
</head>
<body>
    <form method="post" action="">
        <!-- 로그인된 사용자의 ID를 사용 -->
        <?php
            // Check if the user is logged in
            if (isset($_SESSION['userid'])) {
                // Get the logged-in user's ID
                $ID = $_SESSION['userid'];
                echo "<input type='hidden' name='ID' value='$ID'>";
            } 
        ?>
        <br>
            <label for="travel_purpose">Travel Purpose: </label>
            <select name="travel_purpose" id = "travel_purpose" required>
                <option value="Culinary Tourism">Culinary Tourism</option>
                <option value="Shopping">Shopping</option>
                <option value="Enjoying Natural Scenery">Scenic Views</option>
                <option value="Visit to Palaces/Historical Sites">Visit Palaces/Historical Sites</option>
                <option value="Experience Traditional Culture">Cultural Experience</option>
                <option value="Visit to Museums and Exhibitions">Museum, Exhibition Visit</option>
                <option value="Visit to K-POP/Hallyu Star-related Performances">K-POP/Hallyu Performance</option>
                <option value="Visit to Drama/Movie Shooting Locations">Visit Drama/Film Shooting Locations</option>
                <option value="Watching Performances such as Theater, Musicals, Ballet, and Participating in Local Festivals">Theater, Musical, Ballet, etc.</option>
                <option value="Participating in Local Festivals">Participate in Local Festivals</option>
                <option value="Entertainment/Recreation">Entertainment/Leisure</option>
                <option value="Beauty/Medical Tourism">Beauty/Medical Tourism</option>
                <option value="Sports/Recreation">Sports/Recreation</option>
                <option value="Business Activities">Business Activities</option>
                <option value="Training/Education/Research">Training/Education/Research</option>
                <option value="Inspection (Industrial Facilities, etc.)">Inspection (Industrial Facilities, etc.)</option>
            </select>
            
            <br>
            <label for="visit_duration">Visit Duration: </label>
            <select name="visit_duration" id = "visit_duration" required>
                <option value="1~3days">1~3 days</option>
                <option value="4~7days">4~7 days</option>
                <option value="8~10days">8~10 days</option>
                <option value="11~30days">11~30 days</option>
                <option value="61~90days">61~90 days</option>
                <option value="Over 90 days">More than 90 days</option>
            </select>
        <br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
