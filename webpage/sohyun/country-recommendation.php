<?php
// 데이터베이스 연결 정보
$servername = "localhost";
$username = "root";
$password = "thgus201";
$dbname = "php";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 출신 국가별 입출국 공항 비율 데이터 조회
$sql = "SELECT country_of_origin, entry_exit_airport, cnt FROM from_airport";
$result = $conn->query($sql);

// 데이터 배열 초기화
$airportData = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $airportData[$row["country_of_origin"]][] = [
            'entry_exit_airport' => $row["entry_exit_airport"],
            'cnt' => $row["cnt"]
        ];
    }
}

// 출신 국가별 만족도 및 추천 의향 데이터 조회
$sql = "SELECT country_of_origin, satisfaction_avg, recommendation_intent_avg, cnt FROM travel_from_avg";
$result = $conn->query($sql);

// 데이터 배열 초기화
$travelFromData = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $travelFromData[] = [
            'country' => $row["country_of_origin"],
            'satisfaction_avg' => $row["satisfaction_avg"],
            'recommendation_intent_avg' => $row["recommendation_intent_avg"],
            'cnt' => $row["cnt"]
        ];
    }
}

// 데이터베이스 연결 종료
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Visualization</title>
    <!-- Chart.js CDN 추가 -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="/static/css/visit-recom.css" rel="stylesheet" />
    <link href="/static/css/text-style.css" rel="stylesheet" />
</head>
<body>

<?php foreach ($airportData as $country => $airports): ?>
    <h2>Distribution of arrival airports by country : <?php 
    echo $country; ?></h2>
    <center-item>
    <div class="statics-chart">
        <canvas id="airportChart<?php echo $country; ?>" width="400" height="200"></canvas>
    </div>
    </center-item>
    <script>
        var airportData<?php echo $country; ?> = <?php echo json_encode($airports); ?>;

        var airportCtx<?php echo $country; ?> = document.getElementById('airportChart<?php echo $country; ?>').getContext('2d');
        var airportChart<?php echo $country; ?> = new Chart(airportCtx<?php echo $country; ?>, {
            type: 'doughnut',
            data: {
                labels: airportData<?php echo $country; ?>.map(data => data.entry_exit_airport),
                datasets: [{
                    data: airportData<?php echo $country; ?>.map(data => data.cnt),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                    ],
                }]
            }
        });
    </script>
<?php endforeach; ?>

<h2>Satisfaction and recommendation intention by country of origin</h2>
<center-item>
  <div class="statics-chart">
    <canvas id="travelFromChart" width="400" height="200"></canvas>

  </div>
</center-item>
<script>
// 출신 국가별 만족도 및 추천 의향 데이터
var travelFromData = <?php echo json_encode($travelFromData); ?>;

// 출신 국가별 만족도 및 추천 의향 그래프 생성
var travelFromCtx = document.getElementById('travelFromChart').getContext('2d');
var travelFromChart = new Chart(travelFromCtx, {
    type: 'bar',
    data: {
        labels: travelFromData.map(data => data.country),
        datasets: [{
            label: '만족도 평균',
            data: travelFromData.map(data => data.satisfaction_avg),
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }, {
            label: '추천 의향 평균',
            data: travelFromData.map(data => data.recommendation_intent_avg),
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    }
});
</script>

</body>
</html>