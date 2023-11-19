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

$avgSatisfactionByAge = array();
if ($ageResult->num_rows > 0) {
    while ($row = $ageResult->fetch_assoc()) {
        $avgSatisfactionByAge[$row["age"]] = $row["avg_satisfaction"];
    }
}

// 방문 위치에 따른 만족도 통계
$locationQuery = "SELECT visit_location, AVG(satisfaction_avg) AS avg_satisfaction
                  FROM travel_like
                  GROUP BY visit_location
                  ORDER BY avg_satisfaction DESC";
$locationResult = $conn->query($locationQuery);

$avgSatisfactionByLocation = array();
if ($locationResult->num_rows > 0) {
    while ($row = $locationResult->fetch_assoc()) {
        $avgSatisfactionByLocation[$row["visit_location"]] = $row["avg_satisfaction"];
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
    <style>
        .satisfaction-title {
            color:  #2c4035; 
            font-weight: bold; 
            padding-top: 20px;
            font-size: 30px;
        }
        .satisfaction-content {
            padding: 10px;
            background-color: #f8f8f8;
            font-style: italic;
            font-size: 24px;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h1>Travel Satisfaction Statistics</h1>
    <div>
        <h2 class="satisfaction-title">Top 5 Locations by Satisfaction Score</h2>
        <?php 
        $counter = 0;
        foreach($avgSatisfactionByLocation as $location => $satisfaction): 
            if($counter++ < 5):
        ?>
            <p class="satisfaction-content"><?php echo $location . ': ' . $satisfaction; ?></p>
        <?php 
            endif;
        endforeach; 
        ?>
    </div>
    <flex-body>
      <!-- 성별에 따른 바 차트 -->
      <div class="satisfaction-chart">
        <canvas id="genderChart"></canvas>
      </div>
      <div class="satisfaction-chart">
        <canvas id="ageChart" width="200" height="100"></canvas>
      </div>
      <div class="satisfaction-chart">
        <canvas id="locationChart" width="200" height="100"></canvas>
    </flex-body>
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

        // 성별에 따른 바 차트 생성
        createChart('genderChart', 'bar', Object.keys(avgSatisfactionByGender), Object.values(avgSatisfactionByGender), 'rgba(75, 192, 192, 0.2)', 'rgba(75, 192, 192, 1)');

        // 나이에 따른 바 차트 생성
        createChart('ageChart', 'bar', Object.keys(avgSatisfactionByAge), Object.values(avgSatisfactionByAge), 'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 1)');

        // 방문 위치에 따른 도넛 차트 생성
        createChart('locationChart', 'bar', Object.keys(avgSatisfactionByLocation), Object.values(avgSatisfactionByLocation), [
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
