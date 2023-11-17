<?php
// 데이터베이스 연결 정보
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "team07";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 성별에 따른 만족도 통계
$genderQuery = "SELECT gender, AVG(satisfaction_avg) AS avg_satisfaction
                FROM travel_like
                GROUP BY gender";
$genderResult = $conn->query($genderQuery);
$genderData = $genderResult->fetch_all(MYSQLI_ASSOC);

$avgSatisfactionByGender = array();
if ($genderResult->num_rows > 0) {
    while ($row = $genderResult->fetch_assoc()) {
        $avgSatisfactionByGender[$row["gender"]] = $row["avg_satisfaction"];
    }
}

// 나이에 따른 만족도 통계
$ageQuery = "SELECT age, AVG(satisfaction_avg) AS avg_satisfaction
             FROM travel_like
             GROUP BY age";
$ageResult = $conn->query($ageQuery);
$ageData = $ageResult->fetch_all(MYSQLI_ASSOC);

$avgSatisfactionByAge = array();
if ($ageResult->num_rows > 0) {
    while ($row = $ageResult->fetch_assoc()) {
        $avgSatisfactionByAge[$row["age"]] = $row["avg_satisfaction"];
    }
}

// 방문 위치에 따른 만족도 통계
$locationQuery = "SELECT visit_location, AVG(satisfaction_avg) AS avg_satisfaction,
                  RANK() OVER(ORDER BY AVG(satisfaction_avg) DESC) visit_location_rank
                  FROM travel_like
                  GROUP BY visit_location
                  ORDER BY visit_location_rank
                  LIMIT 5";
$locationResult = $conn->query($locationQuery);
$locationData = $locationResult->fetch_all(MYSQLI_ASSOC);

$avgSatisfactionByLocation = array();
if ($locationResult->num_rows > 0) {
    while ($row = $locationResult->fetch_assoc()) {
        $avgSatisfactionByLocation[$row["visit_location"]] = $row["avg_satisfaction"];
    }
}

// 데이터베이스 연결 해제
$conn->close();
?>

<div>
    <!-- 방문 위치에 따른 만족도 상위 5개 데이터 -->
    <h2 class="satisfaction-title">Top 5 Locations by Satisfaction Score</h2>
    <div class="satisfaction-content">
        <?php foreach ($locationData as $location): ?>
            <p>Location: <?= $location['visit_location'] ?>, avg_satisfactio: <?= $location['avg_satisfaction'] ?></p>
        <?php endforeach; ?>
    </div>
</div>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Satisfaction Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="./static/css/likely.css" rel="stylesheet" />
    <style>
        .satisfaction-title {
            color: #f54242; /* 색상 변경 */
            font-weight: bold; /* 볼드체 적용 */
            padding-top: 20px;
            font-size: 30px;
        }
        .satisfaction-content {
            padding: 10px;
            font-weight: bold;
            background-color: #f8f8f8;
            font-size: 24px;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>

    <script >
        // PHP에서 가져온 통계 데이터
        var avgSatisfactionByGender = <?php echo json_encode($avgSatisfactionByGender); ?>;
        var avgSatisfactionByAge = <?php echo json_encode($avgSatisfactionByAge); ?>;
        var avgSatisfactionByLocation = <?php echo json_encode($avgSatisfactionByLocation); ?>;

        // 차트 생성 함수
        function createChart(canvasId, chartType, labels, data, backgroundColor, borderColor) {
            var ctx = document.getElementById(canvasId).getContext('2d');
            return new Chart(ctx, {
                type: chartType,
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Satisfaction',
                        data: data,
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        borderWidth: 1
                    }]
                }
            });
        }
    </script>                                        
</body>
</html>

