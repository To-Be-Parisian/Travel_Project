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
            echo "<script> location.href='./sohyun/home.php';</script>";
        } else {
            echo "오류: " . $sql . "<br>" . $db->error;
        }
    } else {
        // User is not logged in, handle accordingly
        echo '<script> alert("You need login")</script>';
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
            <label for="travel_purpose">Travel Purpose: </label>
            <select name="travel_purpose" required>
                <option value="식도락">식도락 관광</option>
                <option value="쇼핑">쇼핑</option>
                <option value="자연경관">자연경관 감상</option>
                <option value="유적지">고궁/역사 유적지 방문</option>
                <option value="전통문화체험">전통문화체험</option>
                <option value="관람">박물관, 전시관 관람</option>
                <option value="K-POP">K-POP/한류스타 관련 공연장 방문</option>
                <option value="드라마">드라마/영화 촬영지 방문</option>
                <option value="공연">연극, 뮤지컬, 발레 등 공연 관람 및 지역 축제 참여</option>
                <option value="지역">지역 축제 참여</option>
                <option value="유흥">유흥/오락</option>
                <option value="뷰티/의료관광">뷰티/의료관광</option>
                <option value="스포츠">스포츠/레포츠 관람 및 참가 비즈니스 활동</option>
                <option value="업무수행">업무수행</option>
                <option value="연수">연수/교육/연구</option>
                <option value="시찰">시찰 (산업시설 등)</option>
                <!-- Add more options as needed -->
            </select>
            <br>
            <label for="visit_duration">Visit Duration: </label>
            <select name="visit_duration" required>
                <option value="1~3">1~3일</option>
                <option value="4~7">4~7일</option>
                <option value="8~10">8~10일</option>
                <option value="11~30">11~30일</option>
                <option value="61~90">61~90일</option>
                <option value="91">91일 이상</option>
                <!-- Add more options as needed -->
            </select>
        <br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
