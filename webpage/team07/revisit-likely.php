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

// 성별 재방문의향 통계
$genderRevisitQuery = "SELECT gender, AVG(revisit_intent_avg) AS avg_intent
                      FROM travel_revisit
                      GROUP BY gender";
$genderRevisitResult = $conn->query($genderRevisitQuery);

$avgRevisitByGender = array();
if ($genderRevisitResult->num_rows > 0) {
    while ($row = $genderRevisitResult->fetch_assoc()) {
        $avgRevisitByGender[$row["gender"]] = $row["avg_intent"];
    }
}

// 나이별 재방문의향 통계
$ageRevisitQuery = "SELECT age, AVG(revisit_intent_avg) AS avg_intent
                    FROM travel_revisit
                    GROUP BY age";
$ageRevisitResult = $conn->query($ageRevisitQuery);

$avgRevisitByAge = array();
if ($ageRevisitResult->num_rows > 0) {
    while ($row = $ageRevisitResult->fetch_assoc()) {
        $avgRevisitByAge[$row["age"]] = $row["avg_intent"];
    }
}

// 활동별 재방문의향 통계
$activityRevisitQuery = "SELECT main_activity, AVG(revisit_intent_avg) AS avg_intent
                        FROM travel_revisit
                        GROUP BY main_activity";
$activityRevisitResult = $conn->query($activityRevisitQuery);

$avgRevisitByActivity = array();
if ($activityRevisitResult->num_rows > 0) {
    while ($row = $activityRevisitResult->fetch_assoc()) {
        $avgRevisitByActivity[$row["main_activity"]] = $row["avg_intent"];
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="./static/css/likely.css" rel="stylesheet" />
  <title>Revisit</title>
</head>
<body>
  <h1>Revisit likely Statistics</h1>
  <flex-body>
    <div class="revisit-chart">
      <canvas id="genderRevisitChart"></canvas>
    </div>

    <div class="revisit-chart">
        <canvas id="ageRevisitChart"></canvas>
    </div>
  </flex-body>
  <h2>Revisit intent based on activity</h2>
    <div class="revisit-activity">
        <canvas id="activityRevisitChart"></canvas>
    </div>

  <script>
      function createChart(canvasId, chartType, labels, data, backgroundColor, borderColor) {
            var ctx = document.getElementById(canvasId).getContext('2d');
              return new Chart(ctx, {
                  type: chartType,
                  data: {
                      labels: labels,
                      datasets: [{
                          label: 'Revisit',
                          data: data,
                          backgroundColor: backgroundColor,
                          borderColor: borderColor,
                          borderWidth: 1
                      }]
                  }
              });
      }
      // 성별 재방문의향 바 차트 생성
      createChart('genderRevisitChart', 'bar', Object.keys(<?php echo json_encode($avgRevisitByGender); ?>), Object.values(<?php echo json_encode($avgRevisitByGender); ?>), 'rgba(75, 192, 192, 0.2)', 'rgba(75, 192, 192, 1)');

      // 나이별 재방문의향 선 차트 생성
      createChart('ageRevisitChart', 'bar', Object.keys(<?php echo json_encode($avgRevisitByAge); ?>), Object.values(<?php echo json_encode($avgRevisitByAge); ?>), 'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 1)');

      // 활동별 재방문의향 도넛 차트 생성
      createChart('activityRevisitChart', 'bar', Object.keys(<?php echo json_encode($avgRevisitByActivity); ?>), Object.values(<?php echo json_encode($avgRevisitByActivity); ?>), [
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