<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Info Chart</title>
    <!-- Chart.js 라이브러리 추가 -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="/static/css/text-style.css" rel="stylesheet" />
    <link href="/static/css/sex-age.css" rel="stylesheet" />
    <link rel="stylesheet" href="./static/css/home.css">
</head>
<body>

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

// 성별 여행 카운트 쿼리
$genderCountQuery = "SELECT gender, COUNT(*) AS travel_count FROM travel_info GROUP BY gender";
$genderCountResult = $conn->query($genderCountQuery);
$genderCountData = array();

if ($genderCountResult->num_rows > 0) {
    while ($row = $genderCountResult->fetch_assoc()) {
        $genderCountData[$row['gender']] = $row['travel_count'];
    }
}

// 나이별 여행 카운트 쿼리
$ageCountQuery = "SELECT age, COUNT(*) AS travel_count FROM travel_info GROUP BY age";
$ageCountResult = $conn->query($ageCountQuery);
$ageCountData = array();

if ($ageCountResult->num_rows > 0) {
    while ($row = $ageCountResult->fetch_assoc()) {
        $ageCountData[$row['age']] = $row['travel_count'];
    }
}

// 데이터베이스 연결 해제
$conn->close();
?>

<h1>To Be Parsian</h1>
  <?php
        $currentPage = 'satisfaction'; // 현재 페이지 식별자
        include 'nav.php';
    ?>    
<flex-body-col>

  <h2>Travel Count Based On Gender</h2>
  <div class="statics-chart">
      <canvas id="genderChart"></canvas>
  </div>

  <h2>Travel Count Based On Age</h2>
  <!-- 나이별 여행 카운트 바차트 -->
  <div class="statics-chart">
      <canvas id="ageChart"></canvas>
  </div>
</flex-body-col>

<script>
// 성별 여행 카운트 바차트 생성
var genderChartCanvas = document.getElementById('genderChart').getContext('2d');
var genderChart = new Chart(genderChartCanvas, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode(array_keys($genderCountData)); ?>,
        datasets: [{
            label: 'Travel Count by Gender',
            data: <?php echo json_encode(array_values($genderCountData)); ?>,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// 나이별 여행 카운트 바차트 생성
var ageChartCanvas = document.getElementById('ageChart').getContext('2d');
var ageChart = new Chart(ageChartCanvas, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode(array_keys($ageCountData)); ?>,
        datasets: [{
            label: 'Travel Count by Age',
            data: <?php echo json_encode(array_values($ageCountData)); ?>,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

</body>
</html>
