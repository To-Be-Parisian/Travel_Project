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



// 지역에 따른 추천의향 통계
$locationIntentQuery = "SELECT visit_location, AVG(recommendation_intent_avg) AS avg_intent
                        FROM travel_like_avg_location
                        GROUP BY visit_location";
$locationIntentResult = $conn->query($locationIntentQuery);

$avgIntentByLocation = array();
if ($locationIntentResult->num_rows > 0) {
    while ($row = $locationIntentResult->fetch_assoc()) {
        $avgIntentByLocation[$row["visit_location"]] = $row["avg_intent"];
    }
}

// 데이터베이스 연결 해제
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Satisfaction Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="/static/css/likely.css" rel="stylesheet" />
</head>
<body>
    <h1>Travel Recommendation Statistics</h1>
<!-- 지역에 따른 추천의향 도넛 차트 -->
<div class="recommendation-chart">
    <canvas id="locationIntentChart"></canvas>
</div>

<script>
            function createChart(canvasId, chartType, labels, data, backgroundColor, borderColor) {
            var ctx = document.getElementById(canvasId).getContext('2d');
            return new Chart(ctx, {
                type: chartType,
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Recommendation',
                        data: data,
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        borderWidth: 1
                    }]
                }
            });
        }

    // 지역에 따른 추천의향 바 차트 생성
    createChart('locationIntentChart', 'bar', Object.keys(<?php echo json_encode($avgIntentByLocation); ?>), Object.values(<?php echo json_encode($avgIntentByLocation); ?>), [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 200, 200, 0.2)',
        'rgba(200, 200, 255, 0.2)'
    ], [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(255, 200, 200, 1)',
        'rgba(200, 200, 255, 1)'
    ]);
</script>

</body>
</html>
