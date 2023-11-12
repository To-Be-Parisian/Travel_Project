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
        $sql = "INSERT INTO user_input (UserID, purpose , period) VALUES ('$ID', '$travel_purpose', '$visit_duration')";

        if ($db->query($sql) === TRUE) {
            echo "데이터가 성공적으로 삽입되었습니다.";
        } else {
            echo "오류: " . $sql . "<br>" . $db->error;
        }
    } else {
        // User is not logged in, handle accordingly
        echo "로그인이 필요합니다.";
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
            } else {
                // User is not logged in, handle accordingly
                echo '<script> alert("You need login")</script>';
            }
        ?>
        <br>
        <label for="travel_purpose">travel purpose: </label>
        <input type="text" name="travel_purpose" required>
        <br>
        <label for="visit_duration">visit duration: </label>
        <input type="text" name="visit_duration" required>
        <br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
