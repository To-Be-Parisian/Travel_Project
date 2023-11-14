<?php
include "./db.php"; // 데이터베이스 연결 설정 파일

// 폼이 제출되었을 때 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        // Get the logged-in user's ID
        $ID = $_SESSION['user_id'];
        $travel_purpose = $_POST["travel_purpose"];
        $visit_duration = $_POST["visit_duration"];

        // 데이터베이스에 데이터 삽입
        $sql = "INSERT INTO user_input (UserID, purpose , period) VALUES ('".$ID."', '".$travel_purpose."', '".$visit_duration."')";

        if ($db->query($sql) === TRUE) {
            echo "<script> location.href='home.php';</script>";
        } else {
            echo "error: " . $sql . "<br>" . $db->error;
        }
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
            if (isset($_SESSION['user_id'])) {
                // Get the logged-in user's ID
                $ID = $_SESSION['user_id'];
                echo "<input type='hidden' name='ID' value='$ID'>";
            } 
        ?>
        <br>
            <label for="travel_purpose">Travel Purpose: </label>
            <select name="travel_purpose" required>
                <option value="Culinary">Culinary Tourism</option>
                <option value="Shopping">Shopping</option>
                <option value="Scenic">Scenic Views</option>
                <option value="Historical">Visit Palaces/Historical Sites</option>
                <option value="CulturalExperience">Cultural Experience</option>
                <option value="Museum">Museum, Exhibition Visit</option>
                <option value="KPOP">K-POP/Hallyu Performance</option>
                <option value="Drama">Visit Drama/Film Shooting Locations</option>
                <option value="Performance">Theater, Musical, Ballet, etc.</option>
                <option value="LocalFestival">Participate in Local Festivals</option>
                <option value="Entertainment">Entertainment/Leisure</option>
                <option value="BeautyMedical">Beauty/Medical Tourism</option>
                <option value="Sports">Sports/Recreation</option>
                <option value="Business">Business Activities</option>
                <option value="Training">Training/Education/Research</option>
                <option value="Inspection">Inspection (Industrial Facilities, etc.)</option>
                <!-- Add more options as needed -->
            </select>
            </select>
            <br>
            <label for="visit_duration">Visit Duration: </label>
            <select name="visit_duration" required>
                <option value="1~3">1~3 days</option>
                <option value="4~7">4~7 days</option>
                <option value="8~10">8~10 days</option>
                <option value="11~30">11~30 days</option>
                <option value="61~90">61~90 days</option>
                <option value="91">More than 90 days</option>
            </select>
        <br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
